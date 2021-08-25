import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/widgets/order_cancelled_widget.dart';
import 'package:yoo_rider_account_page/widgets/order_completed_widget.dart';
import 'package:yoo_rider_account_page/widgets/order_ongoing_widgets.dart';

class OrderPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 3,
      child: Scaffold(
        appBar: AppBar(
          automaticallyImplyLeading: false,
          title: Text('My Order'),
          bottom: TabBar(
            tabs: <Widget>[
              Tab(text: "Ongoing"),
              Tab(text: "Completed"),
              Tab(text: "Cancelled"),
            ],
          ),
        ),
        body: TabBarView(
          children: <Widget>[
            OrderOngoingWidget(),
            OrderCompletedWidget(),
            OrderCancelledWidget()
          ],
        ),
      ),
    );
  }
}
