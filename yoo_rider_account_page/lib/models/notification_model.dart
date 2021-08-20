class NotificationList {
  List<NotificationModel> notifs;

  NotificationList({
    required this.notifs,
  });
}

class NotificationModel {
  final String title;
  final String subtitle;
  final String message;

  NotificationModel({
    required this.title,
    required this.subtitle,
    required this.message,
  });
}
