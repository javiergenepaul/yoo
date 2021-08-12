import 'package:flutter/material.dart';

Widget profileavatar() {
  return SizedBox(
    height: 100,
    width: 100,
    child: Stack(
      fit: StackFit.expand,
      overflow: Overflow.visible,
      children: [
        CircleAvatar(
          child: Icon(Icons.person),
        ),
        Positioned(
          right: -3,
          bottom: -3,
          child: SizedBox(
            height: 46,
            width: 46,
            child: FlatButton(
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(50),
              ),
              onPressed: () {},
              child: Icon(Icons.add_a_photo_sharp),
            ),
          ),
        )
      ],
    ),
  );
}

Widget editname() {
  return ListTile(
    leading: Icon(Icons.person),
    title: Text('Rider Juan dela Cruz'),
  );
}

Widget editcontact() {
  return ListTile(
    leading: Icon(Icons.phone),
    title: Text('0928476982'),
  );
}

Widget editemail() {
  return ListTile(
    leading: Icon(Icons.email),
    title: TextFormField(
      decoration: InputDecoration.collapsed(
        hintText: 'Email Address',
        hintStyle: TextStyle(fontSize: 15),
      ),
    ),
  );
}

Widget saveButton() {
  return RaisedButton(
    onPressed: () {},
    child: Text('SAVE'),
    padding: EdgeInsets.all(10),
    shape: RoundedRectangleBorder(
      borderRadius: BorderRadius.circular(20),
    ),
  );
}

Widget passwordchange() {
  return Container(
    padding: EdgeInsets.only(
      left: 20,
      right: 20,
    ),
    child: Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          'Change Password',
          style: TextStyle(fontSize: 15, fontWeight: FontWeight.w500),
        ),
        IconButton(
          onPressed: () {},
          icon: Icon(Icons.arrow_forward_ios_outlined),
        ),
      ],
    ),
  );
}

Widget language() {
  return Container(
    padding: EdgeInsets.only(
      left: 20,
      right: 20,
    ),
    child: Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(
          'Language',
          style: TextStyle(fontSize: 15, fontWeight: FontWeight.w500),
        ),
        IconButton(
          onPressed: () {},
          icon: Icon(Icons.arrow_forward_ios_outlined),
        ),
      ],
    ),
  );
}
