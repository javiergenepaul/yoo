import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter_phone_direct_caller/flutter_phone_direct_caller.dart';
import 'package:geolocator/geolocator.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:slide_to_confirm/slide_to_confirm.dart';
import 'package:sliding_up_panel/sliding_up_panel.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/screens/homepage/models/order_model.dart';
import 'package:yoo_rider_account_page/screens/homepage/pages/arrive_pickup_page.dart';
import 'package:yoo_rider_account_page/services/api_service.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';

final pickUpNumberSample = '+639321721859';
final dropOffNumberSample = '+639396266482';

class ActiveOrdersPage extends StatefulWidget {
  const ActiveOrdersPage({Key? key}) : super(key: key);

  @override
  _ActiveOrdersPageState createState() => _ActiveOrdersPageState();
}

class _ActiveOrdersPageState extends State<ActiveOrdersPage> {
  static final CameraPosition _initialCameraPosition =
      CameraPosition(target: LatLng(10.2325, 123.7852), zoom: 15);
  final List<Active?> actives = sampleActiveOrder;
  bool popUp = true;
  Position? currentPosition;
  GoogleMapController? newGoogleMapController;
  Completer<GoogleMapController> _controllerGoogleMap = Completer();

  void locatePosition() async {
    Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high);
    currentPosition = position;

    LatLng latLngPosition = LatLng(position.latitude, position.longitude);

    CameraPosition cameraPosition =
        new CameraPosition(target: latLngPosition, zoom: CameraZoom);
    newGoogleMapController!
        .animateCamera(CameraUpdate.newCameraPosition(cameraPosition));
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.all(5),
      child: Scrollbar(
        child: ListView.builder(
          padding: EdgeInsets.all(8.0),
          itemCount: sampleActiveOrder.length,
          itemBuilder: (context, i) {
            Active? active = actives[i];
            return OrderActiveItems(active!, context);
          },
        ),
      ),
    );
  }

  Widget OrderActiveItems(Active active, context) {
    return Card(
      color: greyOpacity,
      elevation: 8.0,
      margin: EdgeInsets.all(8.0),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: <Widget>[
          ListTile(
              title: Padding(
                padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                child: Column(
                  children: <Widget>[
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: <Widget>[
                        Icon(
                          Icons.inventory_rounded,
                          color: primaryColor,
                        ),
                        SizedBox(
                          width: 10,
                        ),
                        Text('Item Type: ${active.ItemType}'),
                        Spacer(),
                        Text(
                          ' PHP ' + active.Rate.toStringAsFixed(2),
                          style: TextStyle(fontWeight: FontWeight.bold),
                        )
                      ],
                    ),
                    Padding(
                      padding: const EdgeInsets.only(top: 16.0, bottom: 8.0),
                      child: Row(
                        children: <Widget>[
                          Icon(
                            Icons.place,
                            color: primaryColor,
                            size: 22,
                          ),
                          SizedBox(
                            width: 10,
                          ),
                          Text('${active.Pickup}'),
                        ],
                      ),
                    ),
                    Padding(
                      padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                      child: Row(
                        children: <Widget>[
                          Icon(
                            Icons.pin_drop,
                            color: primaryColor,
                          ),
                          SizedBox(
                            width: 10,
                          ),
                          Text(active.DropOff),
                        ],
                      ),
                    ),
                    Padding(
                      padding: const EdgeInsets.only(top: 8.0, bottom: 8.0),
                      child: Row(
                        children: <Widget>[
                          Icon(
                            Icons.event_note,
                            color: primaryColor,
                          ),
                          SizedBox(
                            width: 10,
                          ),
                          Text(active.Schedule),
                          Spacer(),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
              onTap: () {
                showModalBottomSheet(
                  isDismissible: true,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.only(
                      topLeft: Radius.circular(10),
                      topRight: Radius.circular(10),
                    ),
                  ),
                  context: context,
                  builder: (context) => draggableOrderDetails(active, context),
                );
              })
        ],
      ),
    );
  }

  Widget draggableOrderDetails(Active active, context) {
    return Container(
      padding: EdgeInsets.only(top: 5, right: 20, left: 20, bottom: 30),
      height: MediaQuery.of(context).size.height * .4,
      child: Column(
        children: [
          GestureDetector(
            onTap: () {
              Navigator.pop(context);
            },
            child: Center(
              child: Container(
                width: 80,
                height: 5,
                decoration: BoxDecoration(
                  color: Colors.grey[500],
                  borderRadius: BorderRadius.circular(15),
                ),
              ),
            ),
          ),
          SizedBox(height: 10),
          Align(
            alignment: Alignment.center,
            child: Text('Available Order',
                style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: secondaryColor)),
          ),
          SizedBox(height: 20),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    '${active.SenderName}',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.w400),
                  ),
                  Text(
                    'Sender',
                    style: TextStyle(color: secondaryColor),
                  ),
                ],
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Icon(
                        Icons.payment,
                        color: secondaryColor,
                      ),
                      SizedBox(width: 5),
                      Text('PHP ${active.Rate.toStringAsFixed(2)}'),
                    ],
                  ),
                  Row(
                    children: [
                      Icon(
                        Icons.schedule,
                        color: secondaryColor,
                      ),
                      SizedBox(width: 5),
                      Text('${active.Schedule}')
                    ],
                  )
                ],
              )
            ],
          ),
          SizedBox(height: 10),
          Row(
            children: [
              Icon(
                Icons.location_on,
                color: secondaryColor,
                size: 22,
              ),
              SizedBox(width: 5),
              Text(
                '${active.Pickup}',
                style: TextStyle(fontSize: 15, fontWeight: FontWeight.w600),
              ),
            ],
          ),
          SizedBox(height: 20),
          Row(
            children: [
              Icon(
                Icons.pin_drop,
                color: secondaryColor,
              ),
              SizedBox(width: 5),
              Text('${active.DropOff}',
                  style: TextStyle(fontSize: 15, fontWeight: FontWeight.w600)),
            ],
          ),
          Spacer(),
          Center(
            child: Container(
              height: 50,
              width: MediaQuery.of(context).size.width - 20,
              child: ElevatedButton(
                style: ElevatedButton.styleFrom(
                    primary: primaryColor,
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(10))),
                onPressed: () {
                  showAlertDialog(context, active);
                },
                child: Text('Accept Order'),
              ),
            ),
          ),
          // Center(
          //   child: Padding(
          //     padding: EdgeInsets.all(10),
          //     child: GestureDetector(
          //       child: ConfirmationSlider(
          //           height: 50,
          //           width: MediaQuery.of(context).size.width,
          //           foregroundShape: BorderRadius.circular(15),
          //           foregroundColor: primaryColor,
          //           backgroundColor: backgroundOpacity,
          //           backgroundColorEnd: secondaryColor,
          //           backgroundShape: BorderRadius.circular(15),
          //           text: 'Accept Order',
          //           textStyle: TextStyle(color: Colors.black),
          //           onConfirmation: () {
          //             showAlertDialog(context);
          //           }),
          //     ),
          //   ),
          // )
        ],
      ),
    );
  }

  //Alert Dialog Order
  void showAlertDialog(BuildContext context, Active active) {
    showDialog(
        context: context,
        builder: (BuildContext context) {
          return Dialog(
            child: Container(
              padding: const EdgeInsets.all(20),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(
                    Icons.check_circle,
                    size: 100,
                    color: primaryColor,
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  Text(
                    'Order Accepted',
                    style: TextStyle(fontSize: 15),
                  ),
                  SizedBox(
                    height: 20,
                  ),
                  Container(
                    height: 40,
                    width: MediaQuery.of(context).size.width * .3,
                    child: ElevatedButton(
                      style: ButtonStyle(
                        shape:
                            MaterialStateProperty.all<RoundedRectangleBorder>(
                          RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10.0),
                          ),
                        ),
                        backgroundColor:
                            MaterialStateProperty.all<Color>(primaryColor),
                      ),
                      onPressed: () {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) =>
                                senderLocation(active, context),
                          ),
                        );
                      },
                      child: Text(
                        'Done',
                        style: TextStyle(color: Colors.white),
                      ),
                    ),
                  ),
                ],
              ),
            ),
          );
        });
  }

  Widget senderLocation(Active active, context) {
    final panelController = PanelController();
    return Scaffold(
        appBar: AppBar(
          automaticallyImplyLeading: false,
          title: Text('Sender Location'),
        ),
        body: SlidingUpPanel(
            controller: panelController,
            minHeight: MediaQuery.of(context).size.height * .5,
            maxHeight: MediaQuery.of(context).size.height * .9,
            borderRadius: BorderRadius.vertical(top: Radius.circular(10)),
            body: GoogleMap(
              compassEnabled: false,
              tiltGesturesEnabled: false,
              myLocationEnabled: true,
              initialCameraPosition: _initialCameraPosition,
              onMapCreated: (GoogleMapController controller) {
                _controllerGoogleMap.complete(controller);
                newGoogleMapController = controller;
                locatePosition();
              },
            ),
            panelBuilder: (controller) =>
                senderLocationDetails(active, context, panelController)));
  }

  Widget senderLocationDetails(
      Active active, context, PanelController panelController) {
    final ScrollController controller;
    return Container(
      padding: EdgeInsets.only(top: 5, right: 20, left: 20, bottom: 30),
      height: MediaQuery.of(context).size.height * .4,
      child: Column(
        children: [
          GestureDetector(
            onTap: () {
              panelController.isPanelOpen
                  ? panelController.close()
                  : panelController.open();
            },
            child: Center(
              child: Container(
                width: 80,
                height: 5,
                decoration: BoxDecoration(
                  color: Colors.grey[500],
                  borderRadius: BorderRadius.circular(15),
                ),
              ),
            ),
          ),
          SizedBox(height: 10),
          Align(
            alignment: Alignment.center,
            child: Text('Contact Details',
                style: TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: secondaryColor)),
          ),
          SizedBox(height: 10),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    '${active.SenderName}',
                    style: TextStyle(fontSize: 16, fontWeight: FontWeight.w400),
                  ),
                  Text(
                    'Sender',
                    style: TextStyle(color: secondaryColor),
                  ),
                ],
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Icon(
                        Icons.payment,
                        color: secondaryColor,
                      ),
                      SizedBox(width: 5),
                      Text('PHP ${active.Rate.toStringAsFixed(2)}'),
                    ],
                  ),
                  Row(
                    children: [
                      Icon(
                        Icons.schedule,
                        color: secondaryColor,
                      ),
                      SizedBox(width: 5),
                      Text('${active.Schedule}')
                    ],
                  )
                ],
              )
            ],
          ),
          SizedBox(height: 10),
          Row(
            children: [
              Icon(
                Icons.location_on,
                color: secondaryColor,
                size: 22,
              ),
              SizedBox(width: 5),
              Text(
                '${active.Pickup}',
                style: TextStyle(fontSize: 15, fontWeight: FontWeight.w600),
              ),
            ],
          ),
          SizedBox(height: 15),
          Row(
            children: [
              Icon(
                Icons.pin_drop,
                color: secondaryColor,
              ),
              SizedBox(width: 5),
              Text('${active.DropOff}',
                  style: TextStyle(fontSize: 15, fontWeight: FontWeight.w600)),
            ],
          ),
          SizedBox(height: 10),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              //Message Button
              Container(
                height: 45,
                width: MediaQuery.of(context).size.height * .2,
                child: OutlinedButton.icon(
                  onPressed: () {},
                  icon: Icon(Icons.chat_outlined),
                  label: Text('Message'),
                  style: OutlinedButton.styleFrom(
                      primary: primaryColor,
                      side: BorderSide(color: primaryColor),
                      shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10))),
                ),
              ),
              //Call Button
              Container(
                height: 45,
                width: MediaQuery.of(context).size.height * .2,
                child: ElevatedButton.icon(
                  onPressed: () {
                    FlutterPhoneDirectCaller.callNumber(pickUpNumberSample);

                    // launch('tel://$pickUpSample');
                  },
                  icon: Icon(Icons.phone_in_talk),
                  label: Text('Call'),
                  style: ElevatedButton.styleFrom(
                      primary: primaryColor,
                      shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10))),
                ),
              ),
            ],
          ),
          SizedBox(height: 15),
          proceedToPickUpButton(),
          SizedBox(height: 15),
          cancelButton(),
        ],
      ),
    );
  }

  //CancelButton
  Widget cancelButton() {
    return Center(
      child: Container(
          height: 45,
          width: MediaQuery.of(context).size.width,
          child: OutlineButton(
              onPressed: () {},
              child: Text("Cancel Order"),
              borderSide: BorderSide(color: primaryColor),
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10)))),
    );
  }

  Widget proceedToPickUpButton() {
    return Center(
      child: Container(
          height: 45,
          width: MediaQuery.of(context).size.width,
          child: ElevatedButton(
            onPressed: () {
              Navigator.push(context,
                  MaterialPageRoute(builder: (context) => ArrivePickup()));
            },
            child: Text("Proceed to Pickup Point"),
            style: ElevatedButton.styleFrom(
                primary: primaryColor,
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10))),
          )),
    );
  }

//SliderButton
  Widget takeOrderButton(Active active, context) {
    return Center(
      child: Padding(
        padding: EdgeInsets.all(10),
        child: ConfirmationSlider(
          height: 50,
          width: MediaQuery.of(context).size.width - 20,
          foregroundColor: Colors.grey,
          backgroundColor: secondaryColor,
          backgroundColorEnd: primaryColor,
          backgroundShape: BorderRadius.circular(50),
          text: 'Slide to Take Order',
          textStyle: TextStyle(color: Colors.white),
          onConfirmation: () {
            // Navigator.push(
            //   context,
            //   MaterialPageRoute(
            //     builder: (context) =>
            //   ),
            // );
          },
        ),
      ),
    );
  }
}
