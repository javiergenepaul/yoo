import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:intl/intl.dart';
import 'package:yoo_rider_account_page/widgets/add_ons_widget.dart';

class HomePage extends StatefulWidget {
  static const routeName = '/homepage';
  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  var date;
  var time;
  static const _initialCameraPosition =
      CameraPosition(target: LatLng(10.2402, 123.7881), zoom: 15);

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
                        _pickUp(),
                        _dropOff(),
                        _stops(),
                        _pickUpSched(),
                        AddOns(),
                        _proceedButton(),
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

  //Pick Up Field Widget
  Widget _pickUp() {
    return Container(
      padding: EdgeInsets.all(10),
      child: TextFormField(
        decoration: InputDecoration(
          hintText: 'Enter Pick Up Location',
          prefixIcon: Icon(Icons.keyboard_return, size: 20),
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
  Widget _dropOff() {
    return Container(
      padding: EdgeInsets.all(10),
      child: TextFormField(
        decoration: InputDecoration(
          hintText: 'Enter Drop off Location',
          prefixIcon: Icon(Icons.keyboard_return, size: 20),
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
  Widget _stops() {
    return Container(
      padding: EdgeInsets.all(10),
      child: Card(
        child: ExpansionTile(
          title: Text('Stops'),
          leading: IconButton(
            onPressed: () {},
            icon: Icon(Icons.add, size: 20),
          ),
        ),
      ),
    );
  }

//Pick Up Schedule Widget
  Widget _pickUpSched() {
    return Container(
      padding: EdgeInsets.all(10),
      child: Column(
        children: [
          Card(
            child: Container(
              child: ExpansionTile(
                title: Text('Pick Up Schedule'),
                children: [
                  ListTile(
                    onTap: () {
                      pickDate(context);
                    },
                    title: date == null
                        ? Text(
                            'Choose Pick Up Schedule',
                            style: TextStyle(fontSize: 15),
                          )
                        : Text(
                            'Pick Up Schedule: ${date.year}-${date.month}-${date.day}-${date.weekday}',
                            style: TextStyle(fontSize: 15)),
                    leading: Icon(Icons.calendar_today, size: 20),
                  ),
                  ListTile(
                    onTap: () {
                      pickTime(context);
                    },
                    title: time == null
                        ? Text('Choose Pick Up Time',
                            style: TextStyle(fontSize: 15))
                        : Text(
                            'Pick Up Time: ${time.hour.toString().padLeft(2, '0')}:${time.minute.toString().padLeft(2, '0')}',
                            style: TextStyle(fontSize: 15)),
                    leading: Icon(
                      Icons.lock_clock,
                      size: 20,
                    ),
                  ),
                ],
              ),
            ),
          ),
          Card(
            child: Container(
              child: ListTile(
                onTap: () {
                  showModalBottomSheet(
                      context: context,
                      builder: (builder) => homebottomSheet());
                },
                title: Text('Vehicle Type'),
                leading: Icon(Icons.local_car_wash, size: 20),
              ),
            ),
          )
        ],
      ),
    );
  }

//Proceed Button Widget
  Widget _proceedButton() {
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

//Material Calendar Picker
  Future pickDate(BuildContext context) async {
    final initialDate = DateTime.now();
    final newDate = await showDatePicker(
      context: context,
      initialDate: date ?? initialDate,
      firstDate: DateTime(DateTime.now().year - 5),
      lastDate: DateTime(DateTime.now().year + 5),
    );
    if (newDate == null) return;
    setState(() => date = newDate);
  }

//Material Time Picker
  Future pickTime(BuildContext context) async {
    final initialTime = TimeOfDay(hour: 10, minute: 0);
    final newTime = await showTimePicker(
      context: context,
      initialTime: time ?? initialTime,
    );
    if (newTime == null) return;
    setState(() => time = newTime);
  }

//ModalBottomSheet
  Widget homebottomSheet() {
    return Container(
      height: 150,
      child: Column(
        children: <Widget>[
          Text(
            "Select Vehicle",
            style: TextStyle(
              fontSize: 20,
            ),
          ),
          SizedBox(
            height: 40,
          ),
          Container(
            height: 40,
            child: ListView(
              scrollDirection: Axis.horizontal,
              children: <Widget>[
                Container(
                  width: MediaQuery.of(context).size.width * .35,
                  child: ClipRRect(
                    child: FloatingActionButton.extended(
                      onPressed: () {},
                      label: Text(
                        "Motorcycle",
                        style: TextStyle(fontSize: 13),
                      ),
                      icon: Icon(
                        Icons.motorcycle,
                        size: 18,
                      ),
                    ),
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  width: MediaQuery.of(context).size.width * .35,
                  child: FloatingActionButton.extended(
                    onPressed: () {},
                    label: Text(
                      "200kg Sedan",
                      style: TextStyle(fontSize: 13),
                    ),
                    icon: Icon(
                      Icons.local_car_wash_sharp,
                      size: 18,
                    ),
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  width: MediaQuery.of(context).size.width * .35,
                  child: FloatingActionButton.extended(
                    onPressed: () {},
                    label: Text(
                      "300kg MPV",
                      style: TextStyle(fontSize: 13),
                    ),
                    icon: Icon(
                      Icons.car_rental_sharp,
                      size: 18,
                    ),
                  ),
                ),
              ],
            ),
          ),
          // Container(
          //   child: Row(
          //     children: <Widget>[
          //       Container(
          //         child: FloatingActionButton.extended(
          //           onPressed: () {},
          //           label: Text(
          //             "Motorcycle",
          //             style: TextStyle(fontSize: 15),
          //           ),
          //           icon: Icon(
          //             Icons.motorcycle,
          //             size: 20,
          //           ),
          //         ),
          //       ),
          //       Container(
          //         child: FloatingActionButton.extended(
          //           onPressed: () {},
          //           label: Text(
          //             "200kg Sedan",
          //             style: TextStyle(fontSize: 15),
          //           ),
          //           icon: Icon(
          //             Icons.local_car_wash_sharp,
          //             size: 20,
          //           ),
          //         ),
          //       ),
          //       Container(
          //         child: FloatingActionButton.extended(
          //           onPressed: () {},
          //           label: Text(
          //             "300kg MPV",
          //             style: TextStyle(fontSize: 15),
          //           ),
          //           icon: Icon(
          //             Icons.car_rental_sharp,
          //             size: 20,
          //           ),
          //         ),
          //       ),
          //     ],
          //   ),
          // ),
        ],
      ),
    );
  }
}
