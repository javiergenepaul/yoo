import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/order_model.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
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
  late User user;

  @override
  void initState() {
    super.initState();
    user = UserPreferences.getUser();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Order Navigation'),
      ),
      body: Container(
        color: Colors.grey.withOpacity(.05),
        padding: EdgeInsets.only(
          left: 10,
          right: 10,
        ),
        child: Column(
          children: [
            Container(
              color: Colors.white,
              child: Column(
                children: [
                  ListTile(
                    leading: CircleAvatar(
                      child: Icon(Icons.person),
                    ),
                    title: Text(user.userName),
                    subtitle: Text(user.email),
                  ),
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        width: MediaQuery.of(context).size.width * .45,
                        child: RaisedButton(
                          onPressed: () {},
                          child: Text('Button'),
                        ),
                      ),
                      Container(
                        width: MediaQuery.of(context).size.width * .45,
                        child: RaisedButton(
                          onPressed: () {},
                          child: Text('Button2'),
                        ),
                      ),
                    ],
                  )
                ],
              ),
            ),
            // Container(
            //   height: MediaQuery.of(context).size.height * .5,
            //   child: GoogleMap(
            //     myLocationButtonEnabled: false,
            //     zoomControlsEnabled: false,
            //     initialCameraPosition: OrderNavigation._initialCameraPosition,
            //   ),
            // ),
            // SizedBox(
            //   height: 1,
            // ),
            SizedBox(
              height: 5,
            ),
            Container(
              color: Colors.white,
              width: MediaQuery.of(context).size.width,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  ListTile(
                    title: Text('Minglanilla Cebu'),
                    subtitle: Text('949 Tungkop Minglanilla Cebu'),
                  ),
                  ListTile(
                    title: Text('Naga Cebu'),
                    subtitle: Text('Purok Dos Uling City of Naga Cebu'),
                  )
                ],
              ),
            ),
            Container(
              color: Colors.white,
              width: MediaQuery.of(context).size.width,
              padding: EdgeInsets.all(15),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Customer Contact Number',
                    style: TextStyle(fontSize: 12),
                  ),
                  Text(
                    '09123545646',
                    style: TextStyle(fontSize: 16),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  Text(
                    'Service Type',
                    style: TextStyle(fontSize: 12),
                  ),
                  Text(
                    'Motorcycle',
                    style: TextStyle(fontSize: 16),
                  ),
                  SizedBox(
                    height: 10,
                  ),
                  Text(
                    'Remarks',
                    style: TextStyle(fontSize: 12),
                  ),
                  Text(
                    'Hello I am remarks',
                    style: TextStyle(fontSize: 16),
                  ),
                ],
              ),
            )
          ],
        ),
      ),
    );
  }
}
