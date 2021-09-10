class OrderModel {
  List<Ongoing> ongoing;
  List<Completed> completed;
  List<Cancelled> cancelled;

  OrderModel({
    required this.ongoing,
    required this.completed,
    required this.cancelled,
  });
}

class Active {
  final String SenderName;
  final String ReceiverName;
  final String SenderNumber;
  final String ReceiverNumber;
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;
  final bool State;
  final String Remarks;
  final String ItemType;
  final String AddOns;

  Active({
    required this.SenderName,
    required this.ReceiverName,
    required this.SenderNumber,
    required this.ReceiverNumber,
    required this.TransactionID,
    required this.Schedule,
    required this.Time,
    required this.Pickup,
    required this.DropOff,
    required this.Vehicle,
    required this.Rate,
    required this.State,
    required this.Remarks,
    required this.ItemType,
    required this.AddOns,
  });
}

class Ongoing {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;

  const Ongoing({
    required this.TransactionID,
    required this.Schedule,
    required this.Time,
    required this.Pickup,
    required this.DropOff,
    required this.Vehicle,
    required this.Rate,
  });
}

class Completed {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;
  final String DateCompleted;
  final String TimeCompleted;

  const Completed({
    required this.TransactionID,
    required this.Schedule,
    required this.Time,
    required this.Pickup,
    required this.DropOff,
    required this.Vehicle,
    required this.Rate,
    required this.TimeCompleted,
    required this.DateCompleted,
  });
}

class Cancelled {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;
  final String Reason;
  final String DateCancelled;
  final String TimeCancelled;

  const Cancelled({
    required this.TransactionID,
    required this.Schedule,
    required this.Time,
    required this.Pickup,
    required this.DropOff,
    required this.Vehicle,
    required this.Rate,
    required this.DateCancelled,
    required this.TimeCancelled,
    required this.Reason,
  });
}
