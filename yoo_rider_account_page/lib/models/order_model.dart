class OrderModel {
  final String TransactionID;
  final String Schedule;
  final String Time;
  final String Pickup;
  final String DropOff;
  final String Vehicle;
  final double Rate;

  OrderModel({
    required this.TransactionID,
    required this.Schedule,
    required this.Time,
    required this.Pickup,
    required this.DropOff,
    required this.Vehicle,
    required this.Rate,
  });
}
