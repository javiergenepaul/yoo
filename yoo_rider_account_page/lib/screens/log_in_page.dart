import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/rider_account_page.dart';

class LogInPage extends StatefulWidget {
  static const String routeName = '/loginpage';

  @override
  _LogInPageState createState() => _LogInPageState();
}

class _LogInPageState extends State<LogInPage> {
  bool _isHidden = true;
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Container(
          padding: EdgeInsets.only(left: 20, right: 20),
          height: MediaQuery.of(context).size.height,
          width: MediaQuery.of(context).size.height,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              SizedBox(
                height: 150,
              ),
              Text(
                "Yoo",
                style: TextStyle(fontSize: 50, fontWeight: FontWeight.bold),
              ),
              Padding(
                padding: EdgeInsets.all(50.0),
              ),
              Container(
                height: MediaQuery.of(context).size.height * 0.06,
                child: TextFormField(
                  decoration: InputDecoration(
                      prefixIcon: Icon(Icons.mail),
                      border: new OutlineInputBorder(
                          borderRadius: new BorderRadius.circular(5.0),
                          borderSide: new BorderSide()),
                      labelText: 'Email Address'),
                ),
              ),
              Padding(
                padding: EdgeInsets.all(10.0),
              ),
              Container(
                height: MediaQuery.of(context).size.height * 0.06,
                child: TextFormField(
                  decoration: InputDecoration(
                      prefixIcon: Icon(Icons.vpn_key_sharp),
                      suffix: InkWell(
                        onTap: _togglePasswordView,
                        child: Icon(_isHidden
                            ? Icons.visibility_off
                            : Icons.visibility),
                      ),
                      border: new OutlineInputBorder(
                          borderRadius: new BorderRadius.circular(5.0),
                          borderSide: new BorderSide()),
                      labelText: 'password'),
                ),
              ),
              Padding(
                padding: EdgeInsets.all(5.0),
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: <Widget>[
                  RaisedButton(
                    child: Text("Log in"),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(5),
                    ),
                    color: Theme.of(context).primaryColor,
                    onPressed: () {
                      RouteGenerator.navigateTo(LandingPage.routeName);
                    },
                  )
                ],
              ),
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: <Widget>[
                  Text("Not yet registered?"),
                  TextButton(
                    //textColor: Colors.black,
                    child: Text(
                      "Sign Up",
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                    onPressed: () {},
                  )
                ],
              )
            ],
          ),
        ),
      ),
    );
  }

  void _togglePasswordView() {
    setState(() {
      _isHidden = !_isHidden;
    });
  }
}
