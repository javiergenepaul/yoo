import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/widgets/profile_and_security_widgets.dart';

class ProfileSecurityBody extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.all(10),
      child: Column(
        children: <Widget>[
          SafeArea(
            child: Center(
              child: Column(
                children: [
                  SizedBox(
                    height: 20,
                  ),
                  profileavatar()
                ],
              ),
            ),
          ),
          SizedBox(
            height: 20,
          ),
          SafeArea(
            child: Column(
              children: [
                editname(),
                editcontact(),
                editemail(),
              ],
            ),
          ),
          Container(
            margin: EdgeInsets.all(20),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                saveButton(),
              ],
            ),
          ),
          Divider(),
          SafeArea(
            child: Column(
              children: [
                passwordchange(),
                language(),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
