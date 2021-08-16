import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/content/daily_income_summary_details.dart';
import 'package:yoo_rider_account_page/content/monthly_income_summary_details.dart';
import 'package:yoo_rider_account_page/content/weekly_income_summary_details.dart';
import 'package:yoo_rider_account_page/widgets/daily_bar_widget.dart';
import 'package:yoo_rider_account_page/widgets/monthly_bar_widget.dart';
import 'package:yoo_rider_account_page/widgets/weekly_bar_widget.dart';

class RiderIncomeSummary extends StatelessWidget {
  static const routeName = '/riderincomesummary';
  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 3,
      child: Scaffold(
        appBar: AppBar(
          title: Text('Income Statistics'),
          bottom: TabBar(
            tabs: <Widget>[
              Tab(text: "Daily"),
              Tab(text: "Weekly"),
              Tab(text: "Monthly"),
            ],
          ),
        ),
        body: Column(
          children: [
            Flexible(
              flex: 6,
              child: TabBarView(
                children: <Widget>[
                  DailyBarChart(),
                  WeeklyBarChart(),
                  MonthlyBarChart(),
                ],
              ),
            ),
            Flexible(
              flex: 3,
              child: Text('hello'),
            ),
          ],
        ),
      ),
    );
  }
}

// return Scaffold(
//   appBar: AppBar(
//     title: Text('My Income Summary'),
//   ),
//   body: SingleChildScrollView(
//     child: Column(
//       children: [
//         DailyIncomeSummary(),
//         WeeklyIncomeSummary(),
//         MonthlyIncomeSummary(),
//       ],
//     ),
//   ),
// );
