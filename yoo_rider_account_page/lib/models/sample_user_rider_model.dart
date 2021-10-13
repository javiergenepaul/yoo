class Users {
  final String defaultImage;
  final String userName;
  final String number;
  final String email;

  Users({
    required this.defaultImage,
    required this.userName,
    required this.number,
    required this.email,
  });

  Users copy({
    String? defaultImage,
    String? userName,
    String? number,
    String? email,
  }) =>
      Users(
        defaultImage: defaultImage ?? this.defaultImage,
        userName: userName ?? this.userName,
        number: number ?? this.number,
        email: email ?? this.email,
      );

  Map<String, dynamic> toJson() => {
        'defaultImage': defaultImage,
        'userName': userName,
        'number': number,
        'email': email,
      };

  static Users fromJson(Map<String, dynamic> json) => Users(
        defaultImage: json['defaultImage'],
        userName: json['userName'],
        number: json['number'],
        email: json['email'],
      );
}
