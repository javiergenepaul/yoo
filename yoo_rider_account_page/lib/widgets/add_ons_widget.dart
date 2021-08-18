import 'package:flutter/material.dart';

class AddOns extends StatefulWidget {
  const AddOns({Key? key}) : super(key: key);

  @override
  _AddOnsState createState() => _AddOnsState();
}

class _AddOnsState extends State<AddOns> {
  bool checkMark = true;
  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.all(10),
      child: Card(
        color: Colors.white.withOpacity(0.8),
        child: ExpansionTile(
          title: Text('Add ons'),
          children: [
            Column(
              children: [
                ListTile(
                  title: Text('Purchase Service (Max 2,000)'),
                  leading: IconButton(
                    color: Colors.blue,
                    onPressed: () {
                      setState(() {
                        checkMark = !checkMark;
                      });
                    },
                    icon: Icon(checkMark ? Icons.check_box : Icons.check),
                  ),
                  trailing: Text('100.00'),
                ),
                ListTile(
                  title: Text('Queueing Service'),
                  leading: IconButton(
                    color: Colors.blue,
                    onPressed: () {
                      setState(() {
                        checkMark = !checkMark;
                      });
                    },
                    icon: Icon(checkMark ? Icons.check_box : Icons.check),
                  ),
                  trailing: Text('70.00'),
                ),
                ListTile(
                  title: Text('Insulated Box'),
                  leading: IconButton(
                    color: Colors.blue,
                    onPressed: () {
                      setState(() {
                        checkMark = !checkMark;
                      });
                    },
                    icon: Icon(checkMark ? Icons.check_box : Icons.check),
                  ),
                  trailing: Text('0.0'),
                ),
                ListTile(
                  title: Text('Cash Handling (Collect or Deliver Payments)'),
                  leading: IconButton(
                    color: Colors.blue,
                    onPressed: () {
                      setState(() {
                        checkMark = !checkMark;
                      });
                    },
                    icon: Icon(checkMark ? Icons.check_box : Icons.check),
                  ),
                  trailing: Text('30.0'),
                ),
              ],
            )
          ],
        ),
      ),
    );
  }
}
