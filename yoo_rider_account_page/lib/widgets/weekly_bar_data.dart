import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/income_summary_models.dart';

class WeeklyBarData {
  static int interval = 5;

  static List<Data> barData = [
    Data(
      id: 0,
      name: 'Week1',
      y: 10,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 1,
      name: 'Week2',
      y: 12,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 2,
      name: 'Week3',
      y: 5,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 3,
      name: 'Week4',
      y: 17,
      color: Colors.white.withOpacity(0.7),
    ),
  ];
}
