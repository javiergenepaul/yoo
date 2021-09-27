import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/screens/orderspage/widgets/order_cancelled_widget.dart';
import 'package:yoo_rider_account_page/screens/orderspage/widgets/order_completed_widget.dart';
import 'package:yoo_rider_account_page/screens/orderspage/widgets/order_ongoing_widgets.dart';

class OrderPage extends StatelessWidget {
  static const routeName = '/order';
  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
      length: 3,
      child: Scaffold(
        appBar: AppBar(
          title: Text('My Order'),
          bottom: TabBar(
            tabs: <Widget>[
              Tab(text: "Scheduled"),
              Tab(text: "Completed"),
              Tab(text: "Cancelled"),
            ],
            indicatorColor: backgroundOpacity,
          ),
          automaticallyImplyLeading: false,
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
