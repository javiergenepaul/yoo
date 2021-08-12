import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/content/daily_income_summary_details.dart';
import 'package:yoo_rider_account_page/content/monthly_income_summary_details.dart';
import 'package:yoo_rider_account_page/content/weekly_income_summary_details.dart';

class RiderIncomeSummary extends StatelessWidget {
  static const routeName = '/riderincomesummary';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('My Income Summary'),
      ),
      body: SingleChildScrollView(
        child: Column(
          children: [
            DailyIncomeSummary(),
            WeeklyIncomeSummary(),
            MonthlyIncomeSummary(),
          ],
        ),
      ),
    );
  }
}
