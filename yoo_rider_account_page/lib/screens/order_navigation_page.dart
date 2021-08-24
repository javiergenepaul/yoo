import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/widgets/style_theme.dart';

class OrderNavigation extends StatefulWidget {
  static const routeName = 'ordernavigation';
  static const _initialCameraPosition =
      CameraPosition(target: LatLng(10.2402, 123.7881), zoom: 10);

  const OrderNavigation({Key? key}) : super(key: key);

  @override
  State<OrderNavigation> createState() => _OrderNavigationState();
}

class _OrderNavigationState extends State<OrderNavigation> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Order Navigation'),
      ),
      body: Container(
        child: Column(
          children: [
            Container(
              height: MediaQuery.of(context).size.height * .5,
              child: GoogleMap(
                myLocationButtonEnabled: false,
                zoomControlsEnabled: false,
                initialCameraPosition: OrderNavigation._initialCameraPosition,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
