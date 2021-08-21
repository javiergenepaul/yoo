import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';

class OrderNavigation extends StatelessWidget {
  static const routeName = 'ordernavigation';
  static const _initialCameraPosition =
      CameraPosition(target: LatLng(10.2402, 123.7881), zoom: 10);
  const OrderNavigation({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Order Navigation'),
      ),
      body: Container(
        height: MediaQuery.of(context).size.height * .5,
        child: GoogleMap(
          myLocationButtonEnabled: false,
          zoomControlsEnabled: false,
          initialCameraPosition: _initialCameraPosition,
        ),
      ),
    );
  }
}
