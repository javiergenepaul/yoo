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
const LatLng dropOffLocationSample = LatLng(10.3157, 123.8854);
const double CameraZoom = 13;

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
  bool pos = true;
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

  void setMarkers() {
    setState(() {
      _markers.add(
        Marker(
            markerId: MarkerId('origin Pin'),
            infoWindow: InfoWindow(title: 'Origin'),
            position: pickUpLocationSample,
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

  static final CameraPosition _initialCameraPosition =
      CameraPosition(target: currentLocationSample, zoom: CameraZoom);
  static final CameraPosition _destinationCameraPosition =
      CameraPosition(target: pickUpLocationSample, zoom: 16);

  @override
  void initState() {
    super.initState();
    polylinePoints = PolylinePoints();

    //set up initial location
    this.setInitialLocation();
    // this.setPolylines();

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
            markers: _markers,
            polylines: _polylines,
            initialCameraPosition: _initialCameraPosition,
            onMapCreated: (GoogleMapController controller) {
              _controllerGoogleMap.complete(controller);
              newGoogleMapController = controller;
              setPolylines();
              setMarkers();
              locatePosition();
            },
          ),
          Container(
            margin: EdgeInsets.only(left: 15, right: 15),
            height: 60,
            child: Card(
              color: Colors.white,
              child: Container(
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
                                borderRadius: BorderRadius.circular(10))),
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
                                borderRadius: BorderRadius.circular(10))),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
          Positioned(
              bottom: 190,
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
            bottom: 100,
            child: Container(
              padding: EdgeInsets.all(10),
              child: Center(
                child: ConfirmationSlider(
                  height: 50,
                  width: MediaQuery.of(context).size.width - 20,
                  foregroundColor: primaryColor,
                  backgroundColor: backgroundOpacity,
                  backgroundColorEnd: primaryColor,
                  backgroundShape: BorderRadius.circular(10),
                  foregroundShape: BorderRadius.circular(10),
                  text: 'Arrived at Pickup',
                  textStyle: TextStyle(color: Colors.black),
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
      "AIzaSyBL60hAErq0z9XPnxE17_SVW3sUFnMBB3w",
      PointLatLng(
          pickUpLocationSample.latitude, pickUpLocationSample.longitude),
      PointLatLng(
          dropOffLocationSample.latitude, dropOffLocationSample.longitude),
    );
    print(result.points);
    print(result.status);
    if (result.status == 'OK') {
      result.points.forEach((PointLatLng point) {
        polylineCoordinates.add(LatLng(point.latitude, point.longitude));
      });
      setState(() {
        _polylines.add(Polyline(
            polylineId: PolylineId('polyline'),
            width: 4,
            color: Colors.red,
            points: polylineCoordinates));
      });
    }
  }
}
