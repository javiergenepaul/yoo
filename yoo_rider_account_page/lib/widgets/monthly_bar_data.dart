import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/income_summary_models.dart';

class MonthlyBarData {
  static int interval = 5;

  static List<Data> barData = [
    Data(
      id: 0,
      name: 'March',
      y: 12,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 1,
      name: 'April',
      y: 16,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 2,
      name: 'May',
      y: 5,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 3,
      name: 'June',
      y: 7,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 3,
      name: 'July',
      y: 13,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 3,
      name: 'August',
      y: 17,
      color: Colors.white.withOpacity(0.7),
    ),
    Data(
      id: 3,
      name: 'September',
      y: 12,
      color: Colors.white.withOpacity(0.7),
    ),
  ];
}
