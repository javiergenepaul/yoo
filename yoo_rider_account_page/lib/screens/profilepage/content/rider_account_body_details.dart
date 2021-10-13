import 'dart:io';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:image_picker/image_picker.dart';
import 'package:path_provider/path_provider.dart';
import 'package:yoo_rider_account_page/models/get_profile_model.dart';
import 'package:yoo_rider_account_page/models/sample_user_rider_model.dart';
import 'package:yoo_rider_account_page/screens/profilepage/pages/update_profile_page.dart';
import 'package:yoo_rider_account_page/screens/profilepage/widgets/profile_widgets.dart';
import 'package:yoo_rider_account_page/constants/style_theme.dart';
import 'package:yoo_rider_account_page/services/api_service.dart';
import 'package:yoo_rider_account_page/services/fake_data.dart';
import 'package:path/path.dart';

class AccountBodyDetails extends StatefulWidget {
  @override
  State<AccountBodyDetails> createState() => _AccountBodyDetailsState();
}

class _AccountBodyDetailsState extends State<AccountBodyDetails> {
  late Future<GetProfileModel> profileModel;
  late Users user;
  @override
  void initState() {
    profileModel = APIService().getProfile();
    user = UserPreferences.getUser();
    super.initState();
  }

  Future takePhoto(ImageSource source) async {
    final image = await ImagePicker().getImage(
      source: source,
    );

    if (image == null) return;
    final directory = await getApplicationDocumentsDirectory();
    final name = basename(image.path);
    final imageFile = File('${directory.path}/$name');
    final newImage = await File(image.path).copy(imageFile.path);

    setState(() => user = user.copy(defaultImage: newImage.path));
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      child: FutureBuilder<GetProfileModel>(
          future: profileModel,
          builder: (context, snapshot) {
            if (snapshot.hasData) {
              User? driver = snapshot.data!.user;
              return ProfileDetails(driver, context);
            } else {
              return Center(
                child: CircularProgressIndicator(),
              );
            }
          }),
    );
  }

  Widget ProfileDetails(User driver, context) {
    final user = UserPreferences.getUser();
    return Container(
      padding: EdgeInsets.all(15),
      child: Column(
        children: <Widget>[
          SafeArea(
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                SizedBox(
                  height: 20,
                ),
                Container(
                  padding: EdgeInsets.all(10),
                  child: Row(
                    children: [
                      ProfileWidget(
                          isEdit: true,
                          defaultImage: user.defaultImage,
                          onClicked: () {
                            //ModalBottomSheet
                            showModalBottomSheet(
                              context: context,
                              builder: (context) => Container(
                                height:
                                    MediaQuery.of(context).size.height * 0.16,
                                child: Column(
                                  mainAxisAlignment:
                                      MainAxisAlignment.spaceEvenly,
                                  children: <Widget>[
                                    ListTile(
                                      leading: Icon(Icons.camera),
                                      title: Text('Camera'),
                                      onTap: () {
                                        takePhoto(ImageSource.camera);
                                      },
                                    ),
                                    ListTile(
                                      leading: Icon(Icons.image),
                                      title: Text('Gallery'),
                                      onTap: () {
                                        takePhoto(ImageSource.gallery);
                                      },
                                    )
                                  ],
                                ),
                              ),
                            );
                          }),
                      // ProfileWidget(
                      //   defaultImage: user.defaultImage,
                      //   onClicked: () async {
                      //     await Navigator.push(
                      //         context,
                      //         MaterialPageRoute(
                      //             builder: (context) => ProfileSecurity()));
                      //     setState(() {});
                      //   },
                      // ),
                      SizedBox(
                        width: 10,
                      ),
                      Container(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              '${driver.userInfo.firstName} ${driver.userInfo.lastName}',
                              // user.userName,
                              style: TextStyle(
                                  fontWeight: FontWeight.bold, fontSize: 16),
                            ),
                            Text('${driver.email}'),
                            // Text(user.email),
                          ],
                        ),
                      )
                    ],
                  ),
                ),
                SizedBox(
                  height: 10,
                ),
                Container(
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    children: <Widget>[
                      rating(context),
                      Container(
                        height: 24,
                        child: VerticalDivider(
                          color: Colors.black,
                        ),
                      ),
                      buttonDetails(context, '${driver.driver.numberOfFans}',
                          'Followers'),
                      // rating(context),
                      // followers(context),
                    ],
                  ),
                ),
              ],
            ),
          ),
          SizedBox(
            height: 10,
          ),
          Divider(),
          Container(
            alignment: Alignment.centerLeft,
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                TextButton(
                  onPressed: () {},
                  child: Text('Driver ID - ${driver.driver.id}'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Align(
                    alignment: Alignment.centerLeft,
                    child: Text('City - ${driver.driver.city}'),
                  ),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Vehicle Type - ${driver.driver.vehicleModel}'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text(
                      'Driving License Number - ${driver.driver.drivingLicenseNumber}'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text(
                      'License Plate Number - ${driver.driver.drivingLicenseNumber}'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Password'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
                SizedBox(
                  height: 5,
                ),
                TextButton(
                  onPressed: () {},
                  child: Text('Log out'),
                  style: TextButton.styleFrom(
                    primary: Colors.black,
                  ),
                ),
              ],
            ),
          ),
          profileSecurityButton(context),
        ],
      ),
    );
  }

  Widget buttonDetails(BuildContext context, String value, String text) {
    return MaterialButton(
      onPressed: () {},
      child: Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.start,
        children: <Widget>[
          Text(
            value,
            style: TextStyle(fontWeight: FontWeight.w600),
          ),
          SizedBox(
            height: 2,
          ),
          Text(
            text,
            style: TextStyle(fontSize: 12),
          ),
        ],
      ),
    );
  }

  Widget rating(BuildContext context) {
    return Column(
      children: [
        Text(
          'Rating  5.0',
          style: TextStyle(fontWeight: FontWeight.bold),
        ),
        RatingBarIndicator(
          rating: 5,
          itemBuilder: (context, index) => Icon(
            Icons.star,
            color: Colors.amber,
          ),
          itemCount: 5,
          itemSize: 20.0,
          direction: Axis.horizontal,
        ),
      ],
    );
    // Container(
    //   width: MediaQuery.of(context).size.width * .2,
    //   height: MediaQuery.of(context).size.width * .2,
    //   decoration: BoxDecoration(
    //     shape: BoxShape.circle,
    //     border: Border.all(
    //       color: active,
    //       width: 3,
    //     ),
    //   ),
    //   child: Center(
    //     child: Column(
    //       mainAxisAlignment: MainAxisAlignment.center,
    //       children: [
    //         Text(
    //           '4.9',
    //           style: TextStyle(
    //               color: active, fontWeight: FontWeight.w500, fontSize: 18),
    //         ),
    //         Text(
    //           'Rating',
    //           style: TextStyle(fontSize: 13),
    //         ),
    //       ],
    //     ),
    //   ),
    // );
  }

  Widget followers(BuildContext context) {
    return Container(
      width: MediaQuery.of(context).size.width * .2,
      height: MediaQuery.of(context).size.width * .2,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        border: Border.all(
          color: active,
          width: 3,
        ),
      ),
      child: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              '15',
              style: TextStyle(
                  color: active, fontWeight: FontWeight.w500, fontSize: 18),
            ),
            Text(
              'Followers',
              style: TextStyle(fontSize: 13),
            ),
          ],
        ),
      ),
    );
  }

  Widget profileSecurityButton(context) {
    return Center(
      child: Container(
          height: 45,
          width: MediaQuery.of(context).size.width,
          child: ElevatedButton(
            onPressed: () {
              Navigator.push(context,
                  MaterialPageRoute(builder: (context) => UpdateProfile()));
              setState(() {});
            },
            child: Text("Update Information"),
            style: ElevatedButton.styleFrom(
                primary: primaryColor,
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10))),
          )),
    );
  }
}
