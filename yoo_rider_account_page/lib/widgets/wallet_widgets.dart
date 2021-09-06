import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/data/fake_data.dart';
import 'package:yoo_rider_account_page/models/wallet_models.dart';

class WalletWidget extends StatelessWidget {
  List<WalletModel> wallets = sampleWallet;

  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      padding: EdgeInsets.all(8.0),
      itemCount: sampleWallet.length,
      itemBuilder: (ctx, i) {
        WalletModel? wallet = wallets[i];
        return WalletItems(wallet, context);
      },
    );
  }

  Widget WalletItems(WalletModel wallet, BuildContext context) {
    return Card(
        margin: EdgeInsets.all(1.0),
        child: Column(children: <Widget>[
          ListTile(
            title: Text(wallet.title),
            subtitle: Text(wallet.subtitle),
            trailing: Row(
              children: [
                Text(wallet.trailing),
                Icon(Icons.navigate_next),
              ],
            ),
            onTap: () {},
          ),
        ]));
  }
}
