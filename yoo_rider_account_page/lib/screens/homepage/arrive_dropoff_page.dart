import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter_phone_direct_caller/flutter_phone_direct_caller.dart';
import 'package:flutter_polyline_points/flutter_polyline_points.dart';
import 'package:geolocator/geolocator.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:slide_to_confirm/slide_to_confirm.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/screens/homepage/active_order_page.dart';
import 'package:yoo_rider_account_page/screens/homepage/take_orders_page.dart';

final pickUpNumberSample = '+639321721859';
final dropOffNumberSample = '+639396266482';
const LatLng pickUpLocationSample = LatLng(10.2439, 123.7898);
const LatLng dropOffLocationSample = LatLng(10.3157, 123.8854);
const double CameraZoom = 16;

class ArriveDropOff extends StatefulWidget {
  const ArriveDropOff({Key? key}) : super(key: key);

  @override
  _ArriveDropOffState createState() => _ArriveDropOffState();
}

class _ArriveDropOffState extends State<ArriveDropOff> {
  Completer<GoogleMapController> _controllerGoogleMap = Completer();
  // late BitmapDescriptor originIcon;
  // late BitmapDescriptor destinationIcon;
  Set<Polyline> _polylines = Set<Polyline>();
  List<LatLng> polylineCoordinates = [];
  late PolylinePoints polylinePoints;
  Set<Marker> _markers = Set<Marker>();
  Position? currentPosition;
  GoogleMapController? newGoogleMapController;
  GlobalKey<ScaffoldState> scaffoldKey = new GlobalKey<ScaffoldState>();
  late LatLng pickUpSample;
  late LatLng dropOffSample;
  void locatePosition() async {
    Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high);
    currentPosition = position;

    LatLng latLngPosition = LatLng(position.latitude, position.longitude);

    CameraPosition cameraPosition =
        new CameraPosition(target: latLngPosition, zoom: 16);
    newGoogleMapController!
        .animateCamera(CameraUpdate.newCameraPosition(cameraPosition));

    setState(() {
      _markers.add(
        Marker(
            markerId: MarkerId('origin Pin'),
            infoWindow: InfoWindow(title: 'Origin'),
            position: latLngPosition,
            icon:
                BitmapDescriptor.defaultMarkerWithHue(BitmapDescriptor.hueRed)),
      );
      _markers.add(
        Marker(
          markerId: MarkerId('destination Pin'),
          infoWindow: InfoWindow(title: 'Destination'),
          position: dropOffLocationSample,
          icon: BitmapDescriptor.defaultMarkerWithHue(
            BitmapDescriptor.hueGreen,
          ),
        ),
      );
    });
  }

  static const _initialCameraPosition =
      CameraPosition(target: pickUpLocationSample, zoom: 15);
  static const _destinationCameraPosition =
      CameraPosition(target: dropOffLocationSample, zoom: 15);

  @override
  void initState() {
    super.initState();
    polylinePoints = PolylinePoints();

    //set up initial location
    this.setInitialLocation();

    //set up marker icons

    // this.setSourceAndDestinationMarkerIcons();
  }

  void setInitialLocation() {
    pickUpSample =
        LatLng(pickUpLocationSample.latitude, pickUpLocationSample.longitude);
    pickUpSample =
        LatLng(dropOffLocationSample.latitude, dropOffLocationSample.longitude);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Customer Drop Off'),
      ),
      body: Stack(
        children: [
          GoogleMap(
            compassEnabled: false,
            tiltGesturesEnabled: false,
            myLocationEnabled: true,
            markers: _markers,
            polylines: _polylines,
            initialCameraPosition: _initialCameraPosition,
            onMapCreated: (GoogleMapController controller) {
              _controllerGoogleMap.complete(controller);
              newGoogleMapController = controller;
              setPolylines();
              locatePosition();
            },
          ),
          Card(
            color: Colors.white,
            child: Container(
              height: 60,
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                children: [
                  Container(
                    height: 45,
                    width: 130,
                    child: OutlinedButton.icon(
                      onPressed: () {},
                      icon: Icon(Icons.chat_bubble),
                      label: Text('Message'),
                      style: OutlinedButton.styleFrom(
                          primary: primaryColor,
                          side: BorderSide(color: primaryColor),
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(15))),
                    ),
                  ),
                  Container(
                    height: 45,
                    width: 130,
                    child: ElevatedButton.icon(
                      onPressed: () async {
                        await FlutterPhoneDirectCaller.callNumber(
                            pickUpNumberSample);
                        // launch('tel://$pickUpSample');
                      },
                      icon: Icon(Icons.call),
                      label: Text('Call'),
                      style: ElevatedButton.styleFrom(
                          primary: primaryColor,
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(15))),
                    ),
                  ),
                ],
              ),
            ),
          ),
          Positioned(
              bottom: 150,
              right: 10,
              child: FloatingActionButton(
                backgroundColor: primaryColor,
                onPressed: () {
                  newGoogleMapController!.animateCamera(
                      CameraUpdate.newCameraPosition(
                          _destinationCameraPosition));
                },
                child: Icon(Icons.location_on),
              )),
          Positioned(
            bottom: 50,
            child: Container(
              child: Padding(
                padding: EdgeInsets.all(10),
                child: ConfirmationSlider(
                  height: 50,
                  width: MediaQuery.of(context).size.width - 20,
                  foregroundColor: Colors.grey,
                  backgroundColor: secondaryColor,
                  backgroundColorEnd: primaryColor,
                  backgroundShape: BorderRadius.circular(50),
                  text: 'Arrived at DropOff',
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
            ),
          ),
        ],
      ),
    );
  }

  void setPolylines() async {
    PolylineResult result = await polylinePoints.getRouteBetweenCoordinates(
      "AIzaSyC-SoDyK20J4IvpdNgk9085wLdns-Zowqs",
      PointLatLng(pickUpSample.latitude, pickUpSample.longitude),
      PointLatLng(dropOffSample.latitude, dropOffSample.longitude),
    );
    if (result.status == 200) {
      result.points.forEach((PointLatLng point) {
        polylineCoordinates.add(LatLng(point.latitude, point.longitude));
      });
      setState(() {
        _polylines.add(Polyline(
            polylineId: PolylineId('polyline'),
            width: 10,
            color: Colors.red,
            points: polylineCoordinates));
      });
    }
  }
}
