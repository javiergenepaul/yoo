import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/notification_model.dart';

class NotificationWidget extends StatelessWidget {
  List<NotificationModel> notifs = sampleNotif;

  @override
  Widget build(BuildContext context) {
    return Scrollbar(
      child: ListView.builder(
          padding: EdgeInsets.all(8.0),
          itemCount: sampleNotif.length,
          itemBuilder: (ctx, i) {
            NotificationModel? notif = notifs[i];
            return NotificationItems(notif, context);
          }),
    );
  }

  Widget NotificationItems(NotificationModel notif, BuildContext context) {
    return Card(
      margin: EdgeInsets.all(1.0),
      child: Column(
        children: <Widget>[
          ListTile(
            title: Text(notif.title),
            subtitle: Text(notif.subtitle),
            trailing: Text(DateTime.now().toIso8601String()),
            onTap: () {},
          ),
        ],
      ),
    );
  }
}
