import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:yoo_rider_account_page/widgets/add_ons_widget.dart';

class HomePage extends StatefulWidget {
  static const routeName = '/homepage';
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  static const _initialCameraPosition =
      CameraPosition(target: LatLng(10.2433, 123.7890), zoom: 12);
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      appBar: AppBar(
        title: Text("Home"),
      ),
      body: Stack(
        children: [
          GoogleMap(
            myLocationButtonEnabled: false,
            zoomControlsEnabled: false,
            initialCameraPosition: _initialCameraPosition,
          ),
          SingleChildScrollView(
            child: Container(
              padding: EdgeInsets.all(10),
              child: Card(
                color: Colors.white,
                child: ExpansionTile(
                  title: Text('Book Now'),
                  children: <Widget>[
                    Column(
                      children: [
                        _pickUp(context),
                        _dropOff(context),
                        _stops(context),
                        _pickUpSched(context),
                        AddOns(),
                        _proceedButton(context),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

//Pick Up Field Widget
Widget _pickUp(BuildContext context) {
  return Container(
    padding: EdgeInsets.all(10),
    child: TextFormField(
      decoration: InputDecoration(
        hintText: 'Enter Pick Up Location',
        prefixIcon: Icon(Icons.keyboard_return),
        suffixIcon: IconButton(
          onPressed: () {},
          icon: Icon(
            Icons.edit,
          ),
        ),
        border: new OutlineInputBorder(
          borderRadius: new BorderRadius.circular(5.0),
        ),
      ),
    ),
  );
}

//Drop Off Field Widget
Widget _dropOff(BuildContext context) {
  return Container(
    padding: EdgeInsets.all(10),
    child: TextFormField(
      decoration: InputDecoration(
        hintText: 'Enter Drop off Location',
        prefixIcon: Icon(Icons.keyboard_return),
        suffixIcon: IconButton(
          onPressed: () {},
          icon: Icon(
            Icons.edit,
          ),
        ),
        border: new OutlineInputBorder(
          borderRadius: new BorderRadius.circular(5.0),
        ),
      ),
    ),
  );
}

//Stops Widget
Widget _stops(BuildContext context) {
  return Container(
    padding: EdgeInsets.all(10),
    child: Card(
      child: ExpansionTile(
        title: Text('Stops'),
        leading: IconButton(
          onPressed: () {},
          icon: Icon(Icons.add),
        ),
      ),
    ),
  );
}

//Pick Up Schedule Widget
Widget _pickUpSched(BuildContext context) {
  return Container(
    padding: EdgeInsets.all(10),
    child: Column(
      children: [
        Container(
          child: ListTile(
            onTap: () {},
            title: Text('Pick Up Schedule:'),
            leading: Icon(Icons.calendar_today),
          ),
        ),
        Container(
          child: ListTile(
            onTap: () {},
            title: Text('Vehicle Type'),
            leading: Icon(Icons.local_car_wash),
          ),
        )
      ],
    ),
  );
}

//Proceed Button Widget
Widget _proceedButton(BuildContext context) {
  return Container(
    padding: EdgeInsets.all(10),
    alignment: Alignment.centerRight,
    child: FlatButton(
      onPressed: () {},
      child: Text(
        'Proceed',
        style: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w700,
            color: Colors.blueAccent),
      ),
    ),
  );
}
