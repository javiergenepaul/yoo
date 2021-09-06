import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/homepage/take_orders_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/rider_account_page.dart';
import 'package:yoo_rider_account_page/services/rider_login_api_service.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';

class LogInPage extends StatefulWidget {
  static const String routeName = '/loginpage';

  @override
  _LogInPageState createState() => _LogInPageState();
}

class _LogInPageState extends State<LogInPage> {
  bool hidePassword = true;
  final scaffoldKey = GlobalKey<ScaffoldState>();
  GlobalKey<FormState> globalFormKey = new GlobalKey<FormState>();
  APIService apiService = new APIService();
  bool validateAndSave() {
    final form = globalFormKey.currentState;
    if (form!.validate()) {
      form.save();
      return true;
    } else
      return false;
  }

  //TODO: add Controllers for Inputs
  //TODO: add Loading Indicator
  late LoginRequestModel requestModel;

  @override
  void initState() {
    requestModel = LoginRequestModel(mobileNumber: '', password: '');
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: scaffoldKey,
      body: SingleChildScrollView(
        child: Container(
          child: Stack(
            children: <Widget>[
              Container(
                color: Theme.of(context).primaryColor,
                child: Opacity(
                    opacity: 0.5,
                    child: Image.asset("assets/log_in_bckgrnd.png")),
              ),
              Container(
                padding: EdgeInsets.only(left: 20, right: 20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: [
                    SizedBox(
                      height: 50,
                    ),
                    Image.asset(
                      "assets/Logo.png",
                      height: 250,
                      width: 250,
                    ),
                    SizedBox(
                      height: 20,
                    ),
                    Container(
                      child: Form(
                          key: globalFormKey,
                          child: Column(
                            children: <Widget>[
                              Container(
                                child: TextFormField(
                                  cursorColor: Colors.white,
                                  keyboardType: TextInputType.number,
                                  style: TextStyle(color: Colors.white),
                                  onSaved: (input) =>
                                      requestModel.mobileNumber = input!,
                                  validator: (input) => input!.length <= 10
                                      ? "Should consist of 11 digits"
                                      : null,
                                  decoration: InputDecoration(
                                    prefixIcon: Icon(
                                      Icons.phone_android,
                                      color: Colors.white70,
                                    ),
                                    border: new OutlineInputBorder(
                                      borderRadius:
                                          new BorderRadius.circular(5.0),
                                      borderSide: new BorderSide(),
                                    ),
                                    focusedBorder: OutlineInputBorder(
                                        borderRadius:
                                            new BorderRadius.circular(5.0),
                                        borderSide: new BorderSide(
                                            color:
                                                Colors.white.withOpacity(.9))),
                                    enabledBorder: new OutlineInputBorder(
                                        borderRadius:
                                            new BorderRadius.circular(5.0),
                                        borderSide: new BorderSide(
                                            color:
                                                Colors.white.withOpacity(.6))),
                                    hintText: 'Phone Number',
                                    hintStyle: TextStyle(
                                      color: Colors.white,
                                    ),
                                  ),
                                ),
                              ),
                              Padding(
                                padding: EdgeInsets.all(10.0),
                              ),
                              Container(
                                child: TextFormField(
                                  cursorColor: Colors.white,
                                  keyboardType: TextInputType.text,
                                  style: TextStyle(color: Colors.white),
                                  onSaved: (input) =>
                                      requestModel.password = input!,
                                  validator: (input) => input!.length < 3
                                      ? "Password should be more than 3 characters"
                                      : null,
                                  obscureText: hidePassword,
                                  decoration: InputDecoration(
                                      prefixIcon: Icon(
                                        Icons.lock,
                                        color: Colors.white70,
                                      ),
                                      suffixIcon: IconButton(
                                          onPressed: () {
                                            setState(() {
                                              hidePassword = !hidePassword;
                                            });
                                          },
                                          icon: Icon(
                                              hidePassword
                                                  ? Icons.visibility_off
                                                  : Icons.visibility,
                                              color: Colors.white
                                                  .withOpacity(.6))),
                                      border: new OutlineInputBorder(
                                        borderRadius:
                                            new BorderRadius.circular(5.0),
                                        borderSide: new BorderSide(),
                                      ),
                                      focusedBorder: OutlineInputBorder(
                                          borderRadius:
                                              new BorderRadius.circular(5.0),
                                          borderSide: new BorderSide(
                                              color: Colors.white
                                                  .withOpacity(.9))),
                                      enabledBorder: new OutlineInputBorder(
                                          borderRadius:
                                              new BorderRadius.circular(5.0),
                                          borderSide: new BorderSide(
                                              color: Colors.white
                                                  .withOpacity(.6))),
                                      hintText: 'Password',
                                      hintStyle:
                                          TextStyle(color: Colors.white)),
                                ),
                              ),
                              Padding(
                                padding: EdgeInsets.all(5.0),
                              ),
                              SizedBox(
                                height: 120,
                              ),
                              Column(
                                crossAxisAlignment: CrossAxisAlignment.stretch,
                                children: <Widget>[
                                  Container(
                                    height: 50,
                                    child: RaisedButton(
                                      child: Text(
                                        "Log in",
                                        style: TextStyle(color: Colors.white),
                                      ),
                                      shape: RoundedRectangleBorder(
                                        borderRadius: BorderRadius.circular(10),
                                      ),
                                      color: tertiaryColor,
                                      onPressed: () {
                                        if (validateAndSave()) {
                                          // setState(() {
                                          //
                                          // });
                                          apiService
                                              .login(requestModel)
                                              .then((value) {
                                            // setState(() {
                                            //   isApiCallProcess = false;
                                            // });
                                            if (value.token.isNotEmpty) {
                                              final snackbar = SnackBar(
                                                content:
                                                    Text('Log in Successful'),
                                              );
                                              scaffoldKey.currentState!
                                                  .showSnackBar(snackbar);
                                              RouteGenerator.navigateTo(
                                                  LandingPage.routeName);
                                              print(value.token);
                                              print(value.driver.name);
                                              print(value.driver.email);
                                              print(value.driver.city);
                                              print(value.driver.vehicleType);
                                              print(value.driver.dateOfBirth);
                                              print(value.driver.numberOfFans);
                                            } else {
                                              final snackbar = SnackBar(
                                                content: Text('User not found'),
                                              );
                                              scaffoldKey.currentState!
                                                  .showSnackBar(snackbar);
                                            }
                                          });
                                          print(requestModel.toJson());
                                          print(requestModel.mobileNumber);
                                          print(requestModel.password);
                                        }
                                      },
                                    ),
                                  )
                                ],
                              ),
                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: <Widget>[
                                  Text("Don't have an account yet?",
                                      style: fontWhite),
                                  TextButton(
                                    //textColor: Colors.black,
                                    child: Text(
                                      "Register",
                                      style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                          color: Colors.white,
                                          shadows: [
                                            Shadow(
                                              offset: Offset(0, 0),
                                              blurRadius: 5.0,
                                              color: Color(0xFFFFFFFF),
                                            ),
                                          ]),
                                    ),
                                    onPressed: () {},
                                  )
                                ],
                              ),
                            ],
                          )),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
