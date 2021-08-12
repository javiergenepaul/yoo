import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/profile_and_security.dart';

Widget avatar() {
  return CircleAvatar(
    radius: 50,
    child: Icon(Icons.person),
  );
}

Widget username() {
  return Text(
    'Rider Juan dela Cruz',
    style: TextStyle(
      fontSize: 22,
      fontWeight: FontWeight.bold,
    ),
  );
}

Widget accountinfo() {
  return Container(
    child: Row(
      mainAxisAlignment: MainAxisAlignment.spaceEvenly,
      children: [
        rating(),
        followers(),
      ],
    ),
  );
}

Widget rating() {
  return Column(
    children: [
      Text(
        '5.0',
        style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),
      ),
      Text(
        'Rating',
      ),
    ],
  );
}

Widget followers() {
  return Column(
    children: [
      Text(
        '100',
        style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),
      ),
      Text(
        'Followers',
      ),
    ],
  );
}
