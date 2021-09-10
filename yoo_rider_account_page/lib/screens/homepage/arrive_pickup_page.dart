import 'dart:async';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_phone_direct_caller/flutter_phone_direct_caller.dart';
import 'package:flutter_polyline_points/flutter_polyline_points.dart';
import 'package:geolocator/geolocator.dart';
import 'package:image_picker/image_picker.dart';
import 'package:slide_to_confirm/slide_to_confirm.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:yoo_rider_account_page/screens/homepage/take_order_photo.dart';

final pickUpNumberSample = '+639321721859';
final dropOffNumberSample = '+639396266482';
const LatLng pickUpLocationSample = LatLng(10.2439, 123.7898);
const LatLng currentLocationSample = LatLng(10.2325, 123.7852);
const double CameraZoom = 16;

class ArrivePickup extends StatefulWidget {
  const ArrivePickup({Key? key}) : super(key: key);

  @override
  _ArrivePickupState createState() => _ArrivePickupState();
}

class _ArrivePickupState extends State<ArrivePickup> {
  Completer<GoogleMapController> _controllerGoogleMap = Completer();
  // late BitmapDescriptor originIcon;
  // late BitmapDescriptor destinationIcon;
  Set<Polyline> _polylines = Set<Polyline>();
  List<LatLng> polylineCoordinates = [];
  late PolylinePoints polylinePoints;
  Set<Marker> _markers = Set<Marker>();
  GoogleMapController? newGoogleMapController;
  GlobalKey<ScaffoldState> scaffoldKey = new GlobalKey<ScaffoldState>();
  Position? currentPosition;
  late LatLng pickUpSample;
  late LatLng currentSample;
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
          position: pickUpLocationSample,
          icon: BitmapDescriptor.defaultMarkerWithHue(
            BitmapDescriptor.hueGreen,
          ),
        ),
      );
    });
  }

  static final CameraPosition _initialCameraPosition =
      CameraPosition(target: currentLocationSample, zoom: CameraZoom);
  static final CameraPosition _destinationCameraPosition =
      CameraPosition(target: pickUpLocationSample, zoom: CameraZoom);

  @override
  void initState() {
    super.initState();
    polylinePoints = PolylinePoints();

    //set up initial location
    this.setInitialLocation();

    //set up marker icons

    // this.setSourceAndDestinationMarkerIcons();
  }

  // void setSourceAndDestinationMarkerIcons() async {
  //   originIcon = await BitmapDescriptor.fromAssetImage(
  //       ImageConfiguration(devicePixelRatio: 1.0),
  //       'assets/Pickup.png');
  //   destinationIcon = await BitmapDescriptor.fromAssetImage(
  //       ImageConfiguration(devicePixelRatio: 1.0),
  //       'assets/Dropoff.png');
  // }

  void setInitialLocation() {
    currentSample =
        LatLng(currentLocationSample.latitude, currentLocationSample.longitude);
    pickUpSample =
        LatLng(pickUpLocationSample.latitude, pickUpLocationSample.longitude);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Customer Pick Up'),
      ),
      body: Stack(
        children: [
          GoogleMap(
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
                  text: 'Arrived at Pickup',
                  textStyle: TextStyle(color: Colors.white),
                  onConfirmation: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => TakePhoto(),
                      ),
                    );
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
      PointLatLng(currentSample.latitude, currentSample.longitude),
      PointLatLng(pickUpSample.latitude, pickUpSample.longitude),
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
