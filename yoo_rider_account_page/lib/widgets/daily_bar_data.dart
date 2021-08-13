import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'daily_data.dart';

class BarData {
  static int interval = 5;

  static List<Data> barData = [
    Data(
      id: 0,
      name: 'Mon',
      y: 15,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 1,
      name: 'Tue',
      y: 15,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 2,
      name: 'Wed',
      y: 7,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 3,
      name: 'Thur',
      y: 10,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 4,
      name: 'Fri',
      y: 2,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 5,
      name: 'Sat',
      y: 20,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 6,
      name: 'Sun',
      y: 8,
      color: Colors.white.withOpacity(0.7),
    ),
  ];
}
