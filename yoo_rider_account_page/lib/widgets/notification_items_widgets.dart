import 'package:flutter/material.dart';

class NotificationItem extends StatefulWidget {
  final String title;
  final String subtitle;
  final String message;

  NotificationItem(
    this.title,
    this.subtitle,
    this.message,
  );

  @override
  _State createState() => _State();
}

class _State extends State<NotificationItem> {
  @override
  Widget build(BuildContext context) {
    return Card(
      margin: EdgeInsets.all(1.0),
      child: Column(
        children: <Widget>[
          ListTile(
            title: Text(widget.title),
            subtitle: Text(widget.subtitle),
            trailing: Text(DateTime.now().toIso8601String()),
            onTap: () {},
          ),
        ],
      ),
    );
  }
}
