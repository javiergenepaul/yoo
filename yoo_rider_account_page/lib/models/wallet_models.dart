class WalletList {
  List<WalletModel> wallets;
  WalletList({required this.wallets});
}

class WalletModel {
  final String title;
  final String subtitle;
  final String trailing;

  WalletModel({
    required this.title,
    required this.subtitle,
    required this.trailing,
  });
}
