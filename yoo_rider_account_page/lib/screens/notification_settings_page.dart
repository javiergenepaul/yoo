import 'package:flutter/material.dart';

class NotificationSettings extends StatelessWidget {
  static const routeName = '/notifsettings';
  const NotificationSettings({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Notification Settings'),
      ),
    );
  }
}
