import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/models/rider_login_model.dart';
import 'package:yoo_rider_account_page/routes/route_generator.dart';
import 'package:yoo_rider_account_page/screens/Landing_page.dart';
import 'package:yoo_rider_account_page/screens/rider_account_page.dart';
import 'package:yoo_rider_account_page/services/rider_login_api_service.dart';

class LogInPage extends StatefulWidget {
  static const String routeName = '/loginpage';

  @override
  _LogInPageState createState() => _LogInPageState();
}

class _LogInPageState extends State<LogInPage> {
  bool hidePassword = true;
  final scaffoldKey = GlobalKey<ScaffoldState>();
  GlobalKey<FormState> globalFormKey = new GlobalKey<FormState>();
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
          padding: EdgeInsets.only(left: 20, right: 20),
          height: MediaQuery.of(context).size.height,
          width: MediaQuery.of(context).size.height,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: <Widget>[
              Column(
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
                    child: Form(
                        key: globalFormKey,
                        child: Column(
                          children: <Widget>[
                            Container(
                              height: MediaQuery.of(context).size.height * 0.06,
                              child: TextFormField(
                                keyboardType: TextInputType.number,
                                onSaved: (input) =>
                                    requestModel.mobileNumber = input!,
                                validator: (input) =>
                                    input!.contains("+1234567890")
                                        ? "Number only contains integers"
                                        : null,
                                decoration: InputDecoration(
                                  prefixIcon: Icon(Icons.mail),
                                  border: new OutlineInputBorder(
                                      borderRadius:
                                          new BorderRadius.circular(5.0),
                                      borderSide: new BorderSide()),
                                  labelText: 'Contact Number',
                                  hintText: 'Contact Number',
                                ),
                              ),
                            ),
                            Padding(
                              padding: EdgeInsets.all(10.0),
                            ),
                            Container(
                              height: MediaQuery.of(context).size.height * 0.06,
                              child: TextFormField(
                                keyboardType: TextInputType.text,
                                onSaved: (input) =>
                                    requestModel.password = input!,
                                validator: (input) => input!.length < 3
                                    ? "Password should be more than 3 characters"
                                    : null,
                                obscureText: hidePassword,
                                decoration: InputDecoration(
                                    prefixIcon: Icon(Icons.vpn_key_sharp),
                                    suffix: IconButton(
                                        onPressed: () {
                                          setState(() {
                                            hidePassword = !hidePassword;
                                          });
                                        },
                                        icon: Icon(hidePassword
                                            ? Icons.visibility_off
                                            : Icons.visibility)),
                                    border: new OutlineInputBorder(
                                        borderRadius:
                                            new BorderRadius.circular(5.0),
                                        borderSide: new BorderSide()),
                                    labelText: 'Password',
                                    hintText: 'Password'),
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
                                    if (validateAndSave()) {
                                      // setState(() {
                                      //
                                      // });
                                      APIService apiService = new APIService();
                                      apiService
                                          .login(requestModel)
                                          .then((value) {
                                        // setState(() {
                                        //   isApiCallProcess = false;
                                        // });
                                        if (value.token.isNotEmpty) {
                                          final snackbar = SnackBar(
                                            content: Text('Log in Successful'),
                                          );
                                          scaffoldKey.currentState!
                                              .showSnackBar(snackbar);
                                          RouteGenerator.navigateTo(
                                              LandingPage.routeName);
                                          print(value.token);
                                          print(value.driver);
                                        } else if (value.token.isEmpty) {
                                          final snackbar = SnackBar(
                                            content: Text('User not found'),
                                          );
                                          scaffoldKey.currentState!
                                              .showSnackBar(snackbar);
                                        }
                                      });
                                      print(requestModel.toJson());
                                    }
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
                                    style:
                                        TextStyle(fontWeight: FontWeight.bold),
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
            ],
          ),
        ),
      ),
    );
  }
}
