class User {
  final String defaultImage;
  final String userName;
  final String number;
  final String email;

  User({
    required this.defaultImage,
    required this.userName,
    required this.number,
    required this.email,
  });

  User copy({
    String? defaultImage,
    String? userName,
    String? number,
    String? email,
  }) =>
      User(
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

  static User fromJson(Map<String, dynamic> json) => User(
        defaultImage: json['defaultImage'],
        userName: json['userName'],
        number: json['number'],
        email: json['email'],
      );
}
