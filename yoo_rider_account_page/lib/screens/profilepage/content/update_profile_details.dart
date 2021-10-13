import 'package:flutter/material.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/models/get_profile_model.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
import 'package:yoo_rider_account_page/screens/profilepage/content/rider_account_body_details.dart';
import 'package:yoo_rider_account_page/screens/profilepage/widgets/profile_widgets.dart';
import 'package:yoo_rider_account_page/services/api_service.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';

class UpdateProfileDetails extends StatefulWidget {
  @override
  _UpdateProfileDetailsState createState() => _UpdateProfileDetailsState();
}

class _UpdateProfileDetailsState extends State<UpdateProfileDetails> {
  // User user = UserPreferences.myUser;
  late Future<GetProfileModel> profileModel;
  late Users user;
  final ScrollController _controller = ScrollController();
  @override
  void initState() {
    super.initState();
    user = UserPreferences.getUser();
    profileModel = APIService().getProfile();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      child: FutureBuilder<GetProfileModel>(
          future: profileModel,
          builder: (context, snapshot) {
            if (snapshot.hasData) {
              User? driver = snapshot.data!.user;
              return EditUser(driver, context);
            } else {
              return Center(
                child: CircularProgressIndicator(),
              );
            }
          }),
    );
  }

  Widget EditUser(User driver, context) {
    return Container(
      padding: EdgeInsets.all(15),
      child: ListView(
        children: <Widget>[
          SafeArea(
            child: Column(
              children: [
                SizedBox(
                  height: 15,
                ),
                // Container(
                //   padding: EdgeInsets.all(10),
                //   child: ProfileWidget(
                //       isEdit: true,
                //       defaultImage: user.defaultImage,
                //       onClicked: () {
                //         //ModalBottomSheet
                //         showModalBottomSheet(
                //           context: context,
                //           builder: (context) => Container(
                //             height: MediaQuery.of(context).size.height * 0.16,
                //             child: Column(
                //               mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                //               children: <Widget>[
                //                 ListTile(
                //                   leading: Icon(Icons.camera),
                //                   title: Text('Camera'),
                //                   onTap: () {
                //                     takePhoto(ImageSource.camera);
                //                   },
                //                 ),
                //                 ListTile(
                //                   leading: Icon(Icons.image),
                //                   title: Text('Gallery'),
                //                   onTap: () {
                //                     takePhoto(ImageSource.gallery);
                //                   },
                //                 )
                //               ],
                //             ),
                //           ),
                //         );
                //       }),
                // ),
                Row(
                  children: [
                    Flexible(
                      child: ProfileTextField(
                        label: 'Full Name',
                        text: driver.userInfo.firstName,
                        onChanged: (userName) =>
                            user = user.copy(userName: userName),
                      ),
                    ),
                    SizedBox(
                      width: 10,
                    ),
                    Flexible(
                      child: ProfileTextField(
                        label: 'Last Name',
                        text: driver.userInfo.lastName,
                        onChanged: (userName) =>
                            user = user.copy(userName: userName),
                      ),
                    ),
                  ],
                ),
                SizedBox(
                  height: 10,
                ),
                ProfileTextField(
                  label: 'Email Address',
                  text: driver.email,
                  onChanged: (number) => user = user.copy(number: number),
                ),
                SizedBox(
                  height: 10,
                ),
                Row(
                  children: [
                    Flexible(
                      child: ProfileTextField(
                        label: 'City',
                        text: driver.driver.city.toString(),
                        onChanged: (userName) =>
                            user = user.copy(userName: userName),
                      ),
                    ),
                    SizedBox(
                      width: 10,
                    ),
                    Flexible(
                      child: ProfileTextField(
                        label: 'Vehicle Type',
                        text: driver.driver.vehicleModel.toString(),
                        onChanged: (userName) =>
                            user = user.copy(userName: userName),
                      ),
                    ),
                  ],
                ),
                SizedBox(
                  height: 10,
                ),
                ProfileTextField(
                  label: 'Driving License Number',
                  text: driver.driver.drivingLicenseNumber,
                  onChanged: (userName) => user = user.copy(userName: userName),
                ),
                SizedBox(
                  height: 10,
                ),
                ProfileTextField(
                  label: 'License Plate Number',
                  text: driver.driver.licensePlateNumber,
                  onChanged: (userName) => user = user.copy(userName: userName),
                ),
                SizedBox(
                  height: 10,
                ),
                ProfileTextField(
                  hide: true,
                  label: 'Password',
                  text: '',
                  onChanged: (userName) => user = user.copy(userName: userName),
                ),
                // SizedBox(
                //   height: 5,
                // ),
                // ProfileTextField(
                //   label: 'Contact Number',
                //   text: user.number,
                //   onChanged: (number) => user = user.copy(number: number),
                // ),
                // SizedBox(
                //   height: 5,
                // ),
                // ProfileTextField(
                //   label: 'Email Address',
                //   text: user.email,
                //   onChanged: (email) => user = user.copy(email: email),
                // ),

                SizedBox(
                  height: 20,
                ),
                Container(
                  height: 45,
                  width: MediaQuery.of(context).size.width,
                  child: ElevatedButton(
                    onPressed: () {
                      UserPreferences.setUser(user);
                      Navigator.of(context).pop();
                      print(user.userName);
                      print(user.number);
                      print(user.email);
                    },
                    child: Text('Save Information'),
                    style: ElevatedButton.styleFrom(
                        primary: primaryColor,
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10))),
                  ),
                ),
                // SafeArea(
                //   child: Column(
                //     children: [
                //       passwordchange(),
                //       language(),
                //     ],
                //   ),
                // ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

Widget passwordchange() {
  return ListTile(
    title: Text('Change Password'),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () {},
  );
}

Widget language() {
  return ListTile(
    title: Text('Language'),
    trailing: Icon(Icons.arrow_forward_ios_outlined),
    onTap: () {},
  );
}
