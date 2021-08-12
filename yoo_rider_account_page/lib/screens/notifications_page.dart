import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/screens/notification_settings_page.dart';
import 'package:yoo_rider_account_page/widgets/notification_items_widgets.dart';
import 'package:yoo_rider_account_page/widgets/notification_widgets.dart';

class NotificationsPage extends StatelessWidget {
  static const routeName = '/notifications';
  const NotificationsPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // appBar: AppBar(
      //   title: Text('Notifications'),
      //   actions: [
      //     IconButton(
      //         onPressed: () {
      //           Navigator.of(context).pushNamed(NotificationSettings.routeName);
      //         },
      //         icon: Icon(Icons.settings)),
      //   ],
      // ),
      body: NotificationWidget(),
    );
  }
}
