import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/notification_model.dart';
import 'package:yoo_rider_account_page/widgets/notification_items_widgets.dart';

class NotificationWidget extends StatelessWidget {
  final List<NotificationModel> sampleNotif = [
    NotificationModel(
        title: 'Notification',
        subtitle: 'Notification Subject',
        message: 'Notification Message'),
    NotificationModel(
        title: 'Notification',
        subtitle: 'Notification Subject',
        message: 'Notification Message'),
    NotificationModel(
        title: 'Notification',
        subtitle: 'Notification Subject',
        message: 'Notification Message'),
    NotificationModel(
        title: 'Notification',
        subtitle: 'Notification Subject',
        message: 'Notification Message'),
  ];

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
        padding: EdgeInsets.all(8.0),
        itemCount: sampleNotif.length,
        itemBuilder: (ctx, i) => NotificationItem(sampleNotif[i].title,
            sampleNotif[i].subtitle, sampleNotif[i].message),
      ),
    );
  }
}
