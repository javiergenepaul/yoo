import 'package:flutter/foundation.dart';

enum Order { OngoingPage, CompletedPage, CancelledPage }

extension OrderDetailsPageExtension on Order {
  String get name => describeEnum(this);

  String get displayPage {
    switch (this) {
      case Order.OngoingPage:
        return 'Ongoing Page';
      case Order.CompletedPage:
        return 'Completed Page';
      case Order.CancelledPage:
        return 'Cancelled Page';
      default:
        return 'selected title is null';
    }
  }
}
