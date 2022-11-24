
let btn = document.querySelector("#btn");
let sidebar = document.querySelector(".sidebar");


btn.onclick = function () {
    btn.classList.toggle("active");
}
btn.onclick = function () {
    sidebar.classList.toggle("active");
}


// Customer OTP Starts
let customer_request_OTP = {
    "mobile_number": "09000000000"
}
let customer_response_OTP = {
    "message": "OTP created.",
    "data": {
        "otp": 4295,
        "mobile_number": "09000000000",
        "updated_at": "2021-10-06T14:15:50.000000Z",
        "created_at": "2021-10-06T14:15:50.000000Z",
        "id": 1
    }
}
// Customer OTP Ends
// Customer OTP Verify Starts
let customer_request_otpVerify = {
    "otp": "4295",
    "mobile_number": "09000000000",
    "id": "1"
}
let customer_response_otpVerify = {
    "message": "OTP verified.",
    "data": {
        "id": 1,
        "mobile_number": "09000000000",
        "otp": "4295",
        "created_at": "2021-10-18T13:48:12.000000Z",
        "updated_at": "2021-10-18T13:48:12.000000Z"
    }
}
// Customer OTP Verify Ends
// Customer register Start
let customer_request_registration = {
    "mobile_number": "09000000000",
    "email": "customeremail@email.com",
    "password": "customerpassword",
    "password_confirmation": "customerpassword",
}
let customer_response_registration = {
    "message": "User created.",
    "user": {
        "mobile_number": "09000000000",
        "email": "customeremail@email.com",
        "updated_at": "2021-10-18T13:49:39.000000Z",
        "created_at": "2021-10-18T13:49:39.000000Z",
        "id": 1,
        "user_info": {
            "id": 1,
            "user_id": 1,
            "first_name": null,
            "last_name": null,
            "date_of_birth": null,
            "profile_picture": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:49:39.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:49:39.000000Z",
            "verified": 0
        }
    },
    "token": "1|lNZx7Ercgu8cQdwzOj2JG8a3Hk3bcH9hXL49uLrF"
}
// Customer Register Ends
// Customer Login Start
let customer_request_login = {
    "account": "customeremail@email.com",
    "password": "customerpassword",
}
let customer_response_login = {
    "message": "Successfully login.",
    "user": {
        "id": 1,
        "email": "customeremail@email.com",
        "mobile_number": "09000000000",
        "email_verified_at": null,
        "created_at": "2021-10-18T13:49:39.000000Z",
        "updated_at": "2021-10-18T13:49:39.000000Z",
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:49:39.000000Z",
            "verified": 0
        },
        "user_info": {
            "id": 1,
            "user_id": 1,
            "first_name": null,
            "last_name": null,
            "date_of_birth": null,
            "profile_picture": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:49:39.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        }
    },
    "token": "2|YuM3OaNULx9dMr06yA3Ed9WkznLvdJ2pzaI19ufV"
}
// Customer Login Ends
// Customer Profile Starts
let customer_response_profile = {
    "message": "Customer profile.",
    "user": {
        "id": 1,
        "email": "customeremail@email.com",
        "mobile_number": "09000000000",
        "email_verified_at": null,
        "created_at": "2021-10-18T13:49:39.000000Z",
        "updated_at": "2021-10-18T13:49:39.000000Z",
        "user_info": {
            "id": 1,
            "user_id": 1,
            "first_name": null,
            "last_name": null,
            "date_of_birth": null,
            "profile_picture": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:49:39.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:49:39.000000Z",
            "verified": 0
        }
    }
}
// Customer Profile Ends
// Customer Profile Update Starts
let customer_request_profileUpdate = {
    "first_name": "customerFirstNameUpdated",
    "last_name": "customerLastNameUpdated",
    "date_of_birth": "2021-12-30",
    "profile_picture": "(image_type)"
}

let customer_response_profileUpdate = {
    "message": "Profile updated.",
    "user": {
        "id": 1,
        "email": "customeremail@email.com",
        "mobile_number": "09000000000",
        "email_verified_at": null,
        "created_at": "2021-10-18T13:49:39.000000Z",
        "updated_at": "2021-10-18T13:49:39.000000Z",
        "user_info": {
            "id": 1,
            "user_id": 1,
            "first_name": "customerFirstNameUpdated",
            "last_name": "customerLastNameUpdated",
            "date_of_birth": "2021-12-30",
            "profile_picture": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:53:12.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:53:12.000000Z",
            "verified": 1
        }
    }
}
// Customer Profile Update Ends

// Customer Update Order Starts
let customer_response_updateOrder = {
    "message": "Order Updated",
    "order": {
        "id": 1,
        "driver_id": null,
        "completed_datetime": "2022-01-12 17:26:50",
        "order_status_id": 12,
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2022-01-11T07:15:29.000000Z",
        "updated_at": "2022-01-18T06:51:01.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "cancelled_datetime": null,
        "order_status": {
            "id": 12,
            "status": "Cancelled",
            "created_at": "2022-01-11T03:20:06.000000Z",
            "updated_at": "2022-01-11T03:20:06.000000Z"
        },
        "payment_method": {
            "id": 2,
            "method": "Gcash",
            "created_at": "2022-01-11T03:20:06.000000Z",
            "updated_at": "2022-01-11T03:20:06.000000Z"
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2022-01-11T03:20:06.000000Z",
            "updated_at": "2022-01-11T03:20:06.000000Z"
        },
        "customer": {
            "id": 1,
            "user_id": 3,
            "customer_rating": null,
            "created_at": "2022-01-11T07:13:35.000000Z",
            "updated_at": "2022-01-11T07:15:26.000000Z",
            "verified": 1,
            "user": {
                "id": 3,
                "email": "customeremails@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2022-01-11T07:13:35.000000Z",
                "updated_at": "2022-01-11T07:13:35.000000Z",
                "user_info": {
                    "id": 3,
                    "user_id": 3,
                    "first_name": "customerFirstNameUpdated",
                    "last_name": "customerLastNameUpdated",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2022-01-11T07:13:35.000000Z",
                    "updated_at": "2022-01-11T07:15:26.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                }
            }
        },
        "dropoff_locations": [
            {
                "id": 1,
                "order_id": 1,
                "longitude": "1.000000000000000",
                "latitude": "1.000000000000000",
                "name": "name1",
                "contact": "contact1",
                "address": "address1",
                "instruction": "Instruction1",
                "item_type_id": 7,
                "created_at": "2022-01-11T07:15:29.000000Z",
                "updated_at": "2022-01-11T07:15:29.000000Z",
                "mileage": 1,
                "landmark": "landmark1"
            },
            {
                "id": 2,
                "order_id": 1,
                "longitude": "1.000000000000000",
                "latitude": "1.000000000000000",
                "name": "name1",
                "contact": "contact1",
                "address": "address1",
                "instruction": "Instruction1",
                "item_type_id": 7,
                "created_at": "2022-01-11T07:15:29.000000Z",
                "updated_at": "2022-01-11T07:15:29.000000Z",
                "mileage": 1,
                "landmark": "landmark1"
            }
        ]
    }
}
// Customer Update Order Ends

// Customer Create Order Start
let customer_request_createOrder = {
    "p_address": "userAddress",
    "p_lat": "9.5",
    "p_long": "9.5",
    "p_time": "00:00:00",
    "p_date": "2021/09/17",
    "total_mileage": "1",
    "total_amount": "1",
    "vehicle_id": "1",
    "area_id": "1",
    "dropoffs": [{
        "latitude": "9.5",
        "longitude": "9.5",
        "address": "useradd",
        "name": "username",
        "contact": "usercontact",
        "instruction": "userInstruction",
        "mileage": "1",
        "landmark": "userlandmark"
    }]
}
let customer_response_createOrder = {
    "message": "Order created.",
    "order": {
        "customer_id": 1,
        "order_status_id": 1,
        "total_mileage": 1,
        "total_amount": 1,
        "payment_method_id": 2,
        "area_id": 1,
        "vehicle_id": 1,
        "updated_at": "2021-09-30T14:38:21.000000Z",
        "created_at": "2021-09-30T14:38:21.000000Z",
        "id": 2,
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-09-30T08:09:02.000000Z",
            "updated_at": "2021-09-30T08:09:02.000000Z",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09275652944",
                "email_verified_at": null,
                "created_at": "2021-09-30T08:09:02.000000Z",
                "updated_at": "2021-09-30T08:09:02.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "firstNames",
                    "last_name": "lastNames",
                    "date_of_birth": "1990-07-20",
                    "profile_picture": null,
                    "created_at": "2021-09-30T08:09:02.000000Z",
                    "updated_at": "2021-09-30T08:09:02.000000Z"
                }
            }
        },
        "order_status": {
            "id": 1,
            "status": "Ordered",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "payment_method": {
            "id": 2,
            "method": "Cash",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "pickup_info": {
            "id": 2,
            "order_id": 2,
            "address": "userAddress",
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "time": "00:00:00",
            "date": "2021-09-17",
            "created_at": "2021-09-30T14:38:21.000000Z",
            "updated_at": "2021-09-30T14:38:21.000000Z"
        },
        "dropoff_locations": [{
            "id": 2,
            "order_id": 2,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "username",
            "contact": "usercontact",
            "address": "useradd",
            "instruction": "userInstruction",
            "item_type_id": 7,
            "created_at": "2021-09-30T14:38:21.000000Z",
            "updated_at": "2021-09-30T14:38:21.000000Z",
            "mileage": 1,
            "landmark": "userlandmark",
            "item_type": {
                "id": 7,
                "type": "Others",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }],
        "vehicle": {
            "id": 1,
            "type": "Motorcycle",
            "max_weight_kg": 20,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle_dimension": {
                "id": 1,
                "vehicle_id": 1,
                "length_ft": 1.6,
                "width_ft": 1.25,
                "height_ft": 1.6,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            },
            "vehicle_rates": [{
                "id": 1,
                "vehicle_id": 1,
                "area_id": 1,
                "base_fair": 15,
                "charge_per_km": 8,
                "per_add_stop": 30,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z",
                "area": {
                    "id": 1,
                    "description": "cebu",
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }]
        }
    }
}
// Customer Create Order Ends

// Customer Get Ongoing Orders Starts
let customer_response_getOrderOngoing = {
    "message": "Ongoing orders.",
    "total_orders": 1,
    "orders": [{
        "id": 1,
        "driver_id": null,
        "completed_datetime": null,
        "order_status_id": 1,
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2021-09-30T09:06:09.000000Z",
        "updated_at": "2021-09-30T09:06:09.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "order_status": {
            "id": 1,
            "status": "Ordered",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "vehicle": {
            "id": 1,
            "type": "Motorcycle",
            "max_weight_kg": 20,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle_dimension": {
                "id": 1,
                "vehicle_id": 1,
                "length_ft": 1.6,
                "width_ft": 1.25,
                "height_ft": 1.6,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "pickup_info": {
            "id": 1,
            "order_id": 1,
            "address": "userAddress",
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "time": "00:00:00",
            "date": "2021-09-17",
            "created_at": "2021-09-30T09:06:09.000000Z",
            "updated_at": "2021-09-30T09:06:09.000000Z"
        },
        "dropoff_locations": [{
            "id": 1,
            "order_id": 1,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "username",
            "contact": "usercontact",
            "address": "useradd",
            "instruction": "userInstruction",
            "item_type_id": 7,
            "created_at": "2021-09-30T09:06:09.000000Z",
            "updated_at": "2021-09-30T09:06:09.000000Z",
            "mileage": 1,
            "landmark": "userlandmark",
            "item_type": {
                "id": 7,
                "type": "Others",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }]
    }]
}
// Customer Get Ongoing Orders Ends

// Customer Get Completed Orders Starts
let customer_response_getOrderCompleted = {
    "message": "completed orders.",
    "total_orders": 1,
    "orders": [
        {
            "id": 1,
            "driver_id": null,
            "completed_datetime": null,
            "order_status_id": 11,
            "total_mileage": 1,
            "instruction": null,
            "payment_method_id": 2,
            "total_amount": 1,
            "total_paid": 0,
            "total_due": 0,
            "holiday": 0,
            "high_demand": 0,
            "created_at": "2022-01-11T07:15:29.000000Z",
            "updated_at": "2022-01-11T07:15:29.000000Z",
            "area_id": 1,
            "customer_id": 1,
            "vehicle_id": 1,
            "order_status": {
                "id": 11,
                "status": "Completed",
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z"
            },
            "vehicle": {
                "id": 1,
                "type": "Motorcycle",
                "max_weight_kg": 20,
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z",
                "vehicle_dimension": {
                    "id": 1,
                    "vehicle_id": 1,
                    "length_ft": 1.6,
                    "width_ft": 1.25,
                    "height_ft": 1.6,
                    "created_at": "2022-01-11T03:20:06.000000Z",
                    "updated_at": "2022-01-11T03:20:06.000000Z"
                }
            },
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z"
            },
            "pickup_info": {
                "id": 1,
                "order_id": 1,
                "address": "Addressss",
                "longitude": "9.500000000000000",
                "latitude": "9.500000000000000",
                "time": "00:00:00",
                "date": "2021-09-17",
                "created_at": "2022-01-11T07:15:29.000000Z",
                "updated_at": "2022-01-11T07:15:29.000000Z"
            },
            "dropoff_locations": [
                {
                    "id": 1,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2022-01-11T07:15:29.000000Z",
                    "updated_at": "2022-01-11T07:15:29.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2022-01-11T03:20:06.000000Z",
                        "updated_at": "2022-01-11T03:20:06.000000Z"
                    }
                },
                {
                    "id": 2,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2022-01-11T07:15:29.000000Z",
                    "updated_at": "2022-01-11T07:15:29.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2022-01-11T03:20:06.000000Z",
                        "updated_at": "2022-01-11T03:20:06.000000Z"
                    }
                }
            ],
            "customer": {
                "id": 1,
                "user_id": 3,
                "customer_rating": null,
                "created_at": "2022-01-11T07:13:35.000000Z",
                "updated_at": "2022-01-11T07:15:26.000000Z",
                "verified": 1,
                "user": {
                    "id": 3,
                    "email": "customeremails@email.com",
                    "mobile_number": "09000000000",
                    "email_verified_at": null,
                    "created_at": "2022-01-11T07:13:35.000000Z",
                    "updated_at": "2022-01-11T07:13:35.000000Z",
                    "user_info": {
                        "id": 3,
                        "user_id": 3,
                        "first_name": "customerFirstNameUpdated",
                        "last_name": "customerLastNameUpdated",
                        "date_of_birth": "2021-12-30",
                        "profile_picture": null,
                        "created_at": "2022-01-11T07:13:35.000000Z",
                        "updated_at": "2022-01-11T07:15:26.000000Z",
                        "middle_name": null,
                        "country": null,
                        "province": null,
                        "city_municipality": null,
                        "postal_code": null,
                        "barangay": null,
                        "address": null
                    }
                }
            }
        }
    ]
}
// Customer Get Completed Order Ends

// Customer Get Cancelled Order Starts
let customer_response_getOrderCancelled = {
    "message": "cancelled orders.",
    "total_orders": 1,
    "orders": [
        {
            "id": 1,
            "driver_id": null,
            "completed_datetime": null,
            "order_status_id": 12,
            "total_mileage": 1,
            "instruction": null,
            "payment_method_id": 2,
            "total_amount": 1,
            "total_paid": 0,
            "total_due": 0,
            "holiday": 0,
            "high_demand": 0,
            "created_at": "2022-01-11T07:15:29.000000Z",
            "updated_at": "2022-01-11T07:15:29.000000Z",
            "area_id": 1,
            "customer_id": 1,
            "vehicle_id": 1,
            "order_status": {
                "id": 12,
                "status": "Cancelled",
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z"
            },
            "vehicle": {
                "id": 1,
                "type": "Motorcycle",
                "max_weight_kg": 20,
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z",
                "vehicle_dimension": {
                    "id": 1,
                    "vehicle_id": 1,
                    "length_ft": 1.6,
                    "width_ft": 1.25,
                    "height_ft": 1.6,
                    "created_at": "2022-01-11T03:20:06.000000Z",
                    "updated_at": "2022-01-11T03:20:06.000000Z"
                }
            },
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z"
            },
            "pickup_info": {
                "id": 1,
                "order_id": 1,
                "address": "Addressss",
                "longitude": "9.500000000000000",
                "latitude": "9.500000000000000",
                "time": "00:00:00",
                "date": "2021-09-17",
                "created_at": "2022-01-11T07:15:29.000000Z",
                "updated_at": "2022-01-11T07:15:29.000000Z"
            },
            "dropoff_locations": [
                {
                    "id": 1,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2022-01-11T07:15:29.000000Z",
                    "updated_at": "2022-01-11T07:15:29.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2022-01-11T03:20:06.000000Z",
                        "updated_at": "2022-01-11T03:20:06.000000Z"
                    }
                },
                {
                    "id": 2,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2022-01-11T07:15:29.000000Z",
                    "updated_at": "2022-01-11T07:15:29.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2022-01-11T03:20:06.000000Z",
                        "updated_at": "2022-01-11T03:20:06.000000Z"
                    }
                }
            ],
            "customer": {
                "id": 1,
                "user_id": 3,
                "customer_rating": null,
                "created_at": "2022-01-11T07:13:35.000000Z",
                "updated_at": "2022-01-11T07:15:26.000000Z",
                "verified": 1,
                "user": {
                    "id": 3,
                    "email": "customeremails@email.com",
                    "mobile_number": "09000000000",
                    "email_verified_at": null,
                    "created_at": "2022-01-11T07:13:35.000000Z",
                    "updated_at": "2022-01-11T07:13:35.000000Z",
                    "user_info": {
                        "id": 3,
                        "user_id": 3,
                        "first_name": "customerFirstNameUpdated",
                        "last_name": "customerLastNameUpdated",
                        "date_of_birth": "2021-12-30",
                        "profile_picture": null,
                        "created_at": "2022-01-11T07:13:35.000000Z",
                        "updated_at": "2022-01-11T07:15:26.000000Z",
                        "middle_name": null,
                        "country": null,
                        "province": null,
                        "city_municipality": null,
                        "postal_code": null,
                        "barangay": null,
                        "address": null
                    }
                }
            }
        }
    ]
}
// Customer Get Cancelled Orders Ends

// Customer Logout Starts
let customer_response_logout = {
    "message": "Logged out.",
}
// Customer Logout Ends
// Driver Mobile OTP Starts
let driver_request_OTP = {
    "mobile_number": "09000000001",
}
let driver_response_OTP = {
    "message": "OTP created.",
    "data": {
        "otp": 6721,
        "mobile_number": "09000000001",
        "updated_at": "2021-10-18T13:58:08.000000Z",
        "created_at": "2021-10-18T13:58:08.000000Z",
        "id": 2
    }
}
// Driver Mobile OTP Ends
// Driver Mobile OTP Verify Starts
let driver_request_otpVerify = {
    "otp": "6721",
    "mobile_number": "09000000002",
    "id": "2"
}
let driver_response_otpVerify = {
    "message": "OTP verified.",
    "data": {
        "id": 2,
        "mobile_number": "09000000002",
        "otp": "6721",
        "created_at": "2021-10-18T13:58:08.000000Z",
        "updated_at": "2021-10-18T13:58:08.000000Z"
    }
}
// Driver Mobile OTP Verify Ends
// Driver Register Starts
let driver_request_Register = {
    "mobile_number": "09000000002",
    "email": "driversemails@gmail.com",
    "password": "driverpassword",
    "password_confirmation": "driverpassword",
    "sponsor_code": "123456789123456 "
}
let driver_response_Register = {
    "message": "User created.",
    "user": {
        "mobile_number": "09000000002",
        "email": "driversemails@gmail.com",
        "updated_at": "2021-10-18T14:01:08.000000Z",
        "created_at": "2021-10-18T14:01:08.000000Z",
        "id": 3,
        "user_info": {
            "id": 3,
            "user_id": 3,
            "first_name": null,
            "last_name": null,
            "date_of_birth": null,
            "profile_picture": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "driver": {
            "id": 2,
            "user_id": 3,
            "city": null,
            "driving_license_number": null,
            "driving_license_expiry": null,
            "driver_license_image": null,
            "driver_rating": null,
            "nbi_clearance": null,
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "verification_status_id": 1,
            "operator_id": null,
            "verification_status": {
                "id": 1,
                "status": "Profile",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            },
            "driver_vehicles": []
        }
    },
    "token": "4|6GnmOyDyY3cx65pWazqb0LKmb49o34iB4HXB61xg"
}
// Driver Register Ends
// Driver Login Starts
let driver_request_Login = {
    "account": "09000000002",
    "password": "driverpassword"
}
let driver_response_Login = {
    "message": "Successfully login.",
    "user": {
        "id": 3,
        "email": "driversemails@gmail.com",
        "mobile_number": "09000000002",
        "email_verified_at": null,
        "created_at": "2021-10-18T14:01:08.000000Z",
        "updated_at": "2021-10-18T14:01:08.000000Z",
        "driver": {
            "id": 2,
            "user_id": 3,
            "city": null,
            "driving_license_number": null,
            "driving_license_expiry": null,
            "driver_license_image": null,
            "driver_rating": null,
            "nbi_clearance": null,
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "verification_status_id": 1,
            "operator_id": null,
            "verification_status": {
                "id": 1,
                "status": "Profile",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            },
            "driver_vehicles": []
        },
        "user_info": {
            "id": 3,
            "user_id": 3,
            "first_name": null,
            "last_name": null,
            "date_of_birth": null,
            "profile_picture": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        }
    },
    "token": "5|v23sNx1c0HpO43265YCIyRKLUfpzWuYfMrQamYwN"
}
// Driver Login Ends
// Driver Profile Starts
let driver_response_profile = {
    "message": "Driver profile.",
    "user": {
        "id": 3,
        "email": "driversemails@gmail.com",
        "mobile_number": "09000000002",
        "email_verified_at": null,
        "created_at": "2021-10-18T14:01:08.000000Z",
        "updated_at": "2021-10-18T14:01:08.000000Z",
        "user_info": {
            "id": 3,
            "user_id": 3,
            "first_name": null,
            "last_name": null,
            "date_of_birth": null,
            "profile_picture": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "driver": {
            "id": 2,
            "user_id": 3,
            "city": null,
            "driving_license_number": null,
            "driving_license_expiry": null,
            "driver_license_image": null,
            "driver_rating": null,
            "nbi_clearance": null,
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "verification_status_id": 1,
            "operator_id": null,
            "verification_status": {
                "id": 1,
                "status": "Profile",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            },
            "driver_vehicles": [],
            "operator": null
        }
    }
}
// Driver Profile Ends
let driver_request_profileUpdate = {
    "first_name": "driverFirstNameUpdated",
    "last_name": "driverLastNameUdated",
    "date_of_birth": "2021-12-30",
    "profile_picture": "(ImageType)",
    "middle_name": "driverMiddleNameUpdated",
    "driving_license_expiry": "2021-12-30",
    "nbi_clearance": "(ImageType)",
    "vax_certificate": "(ImageType)",
    "driver_license_image": "(ImageType)",
    "driving_license_number": "12345",
    "city": "cebu"
    // "deed_of_sale": "(ImageType)",
    // "vehicle_registration": "(ImageType)",
    // "vehicle_front": "(ImageType)",
    // "vehicle_side": "(ImageType)",
    // "vehicle_back": "(ImageType)",
}
let driver_response_profileUpdate = {
    "message": "Profile updated.",
    "user": {
        "id": 4,
        "email": "driversemail@gmail.com",
        "mobile_number": "09000000001",
        "email_verified_at": null,
        "created_at": "2022-01-11T08:26:24.000000Z",
        "updated_at": "2022-01-11T08:26:24.000000Z",
        "user_info": {
            "id": 4,
            "user_id": 4,
            "first_name": "driverFirstNameUpdated",
            "last_name": "driverLastNameUpdated",
            "date_of_birth": "2021-12-30",
            "profile_picture": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "middle_name": "driverMiddleNameUpdated",
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "driver": {
            "id": 1,
            "user_id": 4,
            "city": "cebu",
            "driving_license_number": "12345",
            "driving_license_expiry": "2021-12-30",
            "driver_license_image": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "driver_rating": null,
            "nbi_clearance": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "verification_status_id": 6,
            "operator_subscription_id": 1,
            "verification_status": {
                "id": 6,
                "status": "Verified",
                "created_at": "2022-01-11T03:20:06.000000Z",
                "updated_at": "2022-01-11T03:20:06.000000Z",
                "ordering_num": 6
            },
            "driver_vehicles": [
                {
                    "id": 1,
                    "driver_id": 1,
                    "vehicle_id": 1,
                    "vehicle_brand": "bike",
                    "vehicle_model": "sushida",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123466",
                    "deed_of_sale": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_registration": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_front": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_side": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_back": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "created_at": null,
                    "updated_at": "2022-01-11T09:46:19.000000Z"
                }
            ],
            "operator_subscription": {
                "id": 1,
                "operator_id": 1,
                "package_id": 1,
                "sponsor_code": "1234567",
                "created_at": "2022-01-11T06:27:56.000000Z",
                "updated_at": "2022-01-11T06:27:56.000000Z",
                "package": {
                    "id": 1,
                    "operator_type_id": 1,
                    "price": null,
                    "driver_limit": 100,
                    "name": null,
                    "sponsor_limit": 100,
                    "created_at": "2022-01-11T06:25:46.000000Z",
                    "updated_at": "2022-01-11T06:25:46.000000Z",
                    "operator_type": {
                        "id": 1,
                        "type": "operator",
                        "rate": 0.07,
                        "created_at": "2022-01-11T03:20:06.000000Z",
                        "updated_at": "2022-01-11T03:20:06.000000Z"
                    }
                }
            }
        }
    }
}
// Driver Profile Update Ends

// Driver Vehicles Starts
let driver_response_vehicles = {
    "message": "Drivers Vehicles",
    "total_vehicles": 6,
    "user": {
        "id": 4,
        "email": "driversemail@gmail.com",
        "mobile_number": "09000000001",
        "email_verified_at": null,
        "created_at": "2022-01-11T08:26:24.000000Z",
        "updated_at": "2022-01-11T08:26:24.000000Z",
        "driver": {
            "id": 1,
            "user_id": 4,
            "city": "cebu",
            "driving_license_number": "12345",
            "driving_license_expiry": "2021-12-30",
            "driver_license_image": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "driver_rating": null,
            "nbi_clearance": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "verification_status_id": 6,
            "operator_subscription_id": 1,
            "driver_vehicles": [
                {
                    "id": 1,
                    "driver_id": 1,
                    "vehicle_id": 1,
                    "vehicle_brand": "bike",
                    "vehicle_model": "sushida",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123466",
                    "deed_of_sale": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_registration": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_front": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_side": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_back": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "created_at": null,
                    "updated_at": "2022-01-11T09:46:19.000000Z"
                },
                {
                    "id": 2,
                    "driver_id": 1,
                    "vehicle_id": null,
                    "vehicle_brand": "brand",
                    "vehicle_model": "model",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123456",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:23:50.000000Z",
                    "updated_at": "2022-01-12T02:23:50.000000Z"
                },
                {
                    "id": 3,
                    "driver_id": 1,
                    "vehicle_id": null,
                    "vehicle_brand": "brand",
                    "vehicle_model": "model",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123456",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:24:18.000000Z",
                    "updated_at": "2022-01-12T02:24:18.000000Z"
                },
                {
                    "id": 4,
                    "driver_id": 1,
                    "vehicle_id": null,
                    "vehicle_brand": "brand",
                    "vehicle_model": "model",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123456",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:26:07.000000Z",
                    "updated_at": "2022-01-12T02:26:07.000000Z"
                },
                {
                    "id": 5,
                    "driver_id": 1,
                    "vehicle_id": null,
                    "vehicle_brand": "brand",
                    "vehicle_model": "model",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123456",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:27:18.000000Z",
                    "updated_at": "2022-01-12T02:27:18.000000Z"
                },
                {
                    "id": 6,
                    "driver_id": 1,
                    "vehicle_id": null,
                    "vehicle_brand": "brand",
                    "vehicle_model": "model",
                    "vehicle_manufacture_year": "2021-12-30",
                    "license_plate_number": "123456",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:28:23.000000Z",
                    "updated_at": "2022-01-12T02:28:23.000000Z"
                }
            ]
        }
    }
}
// Driver Vehicles Ends

// Driver Vehicle Update Starts
let driver_request_vehicleUpdate = {
    "id": "1",
    "vehicle_id": "1",
    "vehicle_brand": "brand",
    "vehicle_model": "model",
    "vehicle_manufacture_year": "2021",
    "license_plate_number": "123466",
    "deed_of_sale": "(ImageType)",
    "vehicle_registration": "(ImageType)",
    "vehicle_front": "(ImageType)",
    "vehicle_side": "(ImageType)",
    "vehicle_back": "(ImageType)",
}
let driver_response_vehicleUpdate = {
    "message": "Driver Vehicle Updated",
    "user": {
        "id": 4,
        "email": "driversemail@gmail.com",
        "mobile_number": "09000000001",
        "email_verified_at": null,
        "created_at": "2022-01-11T08:26:24.000000Z",
        "updated_at": "2022-01-11T08:26:24.000000Z",
        "driver": {
            "id": 1,
            "user_id": 4,
            "city": "cebu",
            "driving_license_number": "12345",
            "driving_license_expiry": "2021-12-30",
            "driver_license_image": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "driver_rating": null,
            "nbi_clearance": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "verification_status_id": 6,
            "operator_subscription_id": 1,
            "driver_vehicles": [
                {
                    "id": 1,
                    "driver_id": 1,
                    "vehicle_id": 1,
                    "vehicle_brand": "bike",
                    "vehicle_model": "sushida",
                    "vehicle_manufacture_year": "2021",
                    "license_plate_number": "123466",
                    "deed_of_sale": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_registration": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_front": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_side": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_back": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "created_at": null,
                    "updated_at": "2022-01-11T09:46:19.000000Z"
                },
                {
                    "id": 2,
                    "driver_id": 1,
                    "vehicle_id": null,
                    "vehicle_brand": "brand",
                    "vehicle_model": "model",
                    "vehicle_manufacture_year": "2021",
                    "license_plate_number": "123456",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:23:50.000000Z",
                    "updated_at": "2022-01-12T02:23:50.000000Z"
                },
            ]
        },
        "user_info": {
            "id": 4,
            "user_id": 4,
            "first_name": "driverFirstNameUpdated",
            "last_name": "driverLastNameUpdated",
            "date_of_birth": "2021-12-30",
            "profile_picture": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "middle_name": "driverMiddleNameUpdated",
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        }
    }
}
// Driver Vehicle Update Ends

// Driver Vehicle Create Starts
let driver_request_vehicleCreate = {
    "vehicle_id": "1",
    "vehicle_brand": "brand",
    "vehicle_model": "model",
    "vehicle_manufacture_year": "2021",
    "license_plate_number": "123466",
    "deed_of_sale": "(ImageType)",
    "vehicle_registration": "(ImageType)",
    "vehicle_front": "(ImageType)",
    "vehicle_side": "(ImageType)",
    "vehicle_back": "(ImageType)",
}

let driver_response_vehicleCreate = {
    "message": "Vehicle Added.",
    "user": {
        "id": 4,
        "email": "driversemail@gmail.com",
        "mobile_number": "09000000001",
        "email_verified_at": null,
        "created_at": "2022-01-11T08:26:24.000000Z",
        "updated_at": "2022-01-11T08:26:24.000000Z",
        "driver": {
            "id": 1,
            "user_id": 4,
            "city": "cebu",
            "driving_license_number": "12345",
            "driving_license_expiry": "2021-12-30",
            "driver_license_image": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "driver_rating": null,
            "nbi_clearance": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "status": 0,
            "number_of_fans": null,
            "vax_certificate": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "verification_status_id": 6,
            "operator_subscription_id": 1,
            "driver_vehicles": [
                {
                    "id": 1,
                    "driver_id": 1,
                    "vehicle_id": 2,
                    "vehicle_brand": "brand boi",
                    "vehicle_model": "model boi",
                    "vehicle_manufacture_year": "2021",
                    "license_plate_number": "123466",
                    "deed_of_sale": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_registration": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_front": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_side": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "vehicle_back": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641894379.jpg",
                    "created_at": null,
                    "updated_at": "2022-01-12T05:21:18.000000Z"
                },
                {
                    "id": 2,
                    "driver_id": 1,
                    "vehicle_id": 2,
                    "vehicle_brand": "brand boi",
                    "vehicle_model": "model boi",
                    "vehicle_manufacture_year": "2021",
                    "license_plate_number": "123466",
                    "deed_of_sale": null,
                    "vehicle_registration": null,
                    "vehicle_front": null,
                    "vehicle_side": null,
                    "vehicle_back": null,
                    "created_at": "2022-01-12T02:23:50.000000Z",
                    "updated_at": "2022-01-12T05:21:28.000000Z"
                }
            ]
        },
        "user_info": {
            "id": 4,
            "user_id": 4,
            "first_name": "driverFirstNameUpdated",
            "last_name": "driverLastNameUpdated",
            "date_of_birth": "2021-12-30",
            "profile_picture": "france-in-pictures-beautiful-places-to-photograph-eiffel-tower_1641955459.jpg",
            "created_at": "2022-01-11T08:26:24.000000Z",
            "updated_at": "2022-01-12T02:44:19.000000Z",
            "middle_name": "driverMiddleNameUpdated",
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        }
    }
}
// Driver Vehicle Create Ends

// Driver Get Order Available Starts
let driver_response_getOrderAvailable = {
    "message": "Available orders.",
    "total_orders": 1,
    "orders": [{
        "id": 1,
        "driver_id": null,
        "completed_datetime": null,
        "order_status_id": 1,
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2021-10-18T13:55:01.000000Z",
        "updated_at": "2021-10-18T13:55:01.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "order_status": {
            "id": 1,
            "status": "Ordered",
            "created_at": "2021-10-18T13:45:44.000000Z",
            "updated_at": "2021-10-18T13:45:44.000000Z"
        },
        "vehicle": {
            "id": 1,
            "type": "Motorcycle",
            "max_weight_kg": 20,
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z",
            "vehicle_dimension": {
                "id": 1,
                "vehicle_id": 1,
                "length_ft": 1.6,
                "width_ft": 1.25,
                "height_ft": 1.6,
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            }
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "pickup_info": {
            "id": 1,
            "order_id": 1,
            "address": "Addressss",
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "time": "00:00:00",
            "date": "2021-09-17",
            "created_at": "2021-10-18T13:55:01.000000Z",
            "updated_at": "2021-10-18T13:55:01.000000Z"
        },
        "dropoff_locations": [{
            "id": 1,
            "order_id": 1,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "samplename",
            "contact": "samplecontact",
            "address": "sampleadd",
            "instruction": "sampleInstruction",
            "item_type_id": 7,
            "created_at": "2021-10-18T13:55:02.000000Z",
            "updated_at": "2021-10-18T13:55:02.000000Z",
            "mileage": 1,
            "landmark": "samplelandmark",
            "item_type": {
                "id": 7,
                "type": "Others",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            }
        }],
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:53:12.000000Z",
            "verified": 1,
            "user": {
                "id": 1,
                "email": "customeremail@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-18T13:49:39.000000Z",
                "updated_at": "2021-10-18T13:49:39.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "customerFirstNameUpdated",
                    "last_name": "customerLastNameUpdated",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2021-10-18T13:49:39.000000Z",
                    "updated_at": "2021-10-18T13:53:12.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                }
            }
        }
    }]
}
// Driver Get Available Orders Ends
// Driver Get Ongoing Order Starts
let driver_response_ongoingOrder = {
    "message": "Ongoing orders.",
    "total_orders": 1,
    "orders": [{
        "id": 1,
        "driver_id": 2,
        "completed_datetime": null,
        "order_status_id": 2,
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2021-10-18T13:55:01.000000Z",
        "updated_at": "2021-10-18T14:32:07.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "order_status": {
            "id": 2,
            "status": "Assigned",
            "created_at": "2021-10-18T13:45:44.000000Z",
            "updated_at": "2021-10-18T13:45:44.000000Z"
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "pickup_info": {
            "id": 1,
            "order_id": 1,
            "address": "Addressss",
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "time": "00:00:00",
            "date": "2021-09-17",
            "created_at": "2021-10-18T13:55:01.000000Z",
            "updated_at": "2021-10-18T13:55:01.000000Z"
        },
        "dropoff_locations": [{
            "id": 1,
            "order_id": 1,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "samplename",
            "contact": "samplecontact",
            "address": "sampleadd",
            "instruction": "sampleInstruction",
            "item_type_id": 7,
            "created_at": "2021-10-18T13:55:02.000000Z",
            "updated_at": "2021-10-18T13:55:02.000000Z",
            "mileage": 1,
            "landmark": "samplelandmark",
            "item_type": {
                "id": 7,
                "type": "Others",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            }
        }],
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:53:12.000000Z",
            "verified": 1,
            "user": {
                "id": 1,
                "email": "customeremail@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-18T13:49:39.000000Z",
                "updated_at": "2021-10-18T13:49:39.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "customerFirstNameUpdated",
                    "last_name": "customerLastNameUpdated",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2021-10-18T13:49:39.000000Z",
                    "updated_at": "2021-10-18T13:53:12.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                }
            }
        }
    }]
}
// Driver Get Ongoing Order Ends

// Driver Get Completed Order Starts
let driver_response_completedOrder = {
    "message": "Ongoing orders.",
    "total_completed_orders": 1,
    "orders": [
        {
            "id": 1,
            "driver_id": 1,
            "completed_datetime": null,
            "order_status_id": 11,
            "total_mileage": 1,
            "instruction": null,
            "payment_method_id": 2,
            "total_amount": 1,
            "total_paid": 0,
            "total_due": 0,
            "holiday": 0,
            "high_demand": 0,
            "created_at": "2021-12-08T06:30:45.000000Z",
            "updated_at": "2021-12-08T06:32:45.000000Z",
            "area_id": 1,
            "customer_id": 1,
            "vehicle_id": 1,
            "order_status": {
                "id": 11,
                "status": "Completed",
                "created_at": "2021-12-04T14:50:48.000000Z",
                "updated_at": "2021-12-04T14:50:48.000000Z"
            },
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-12-04T14:50:48.000000Z",
                "updated_at": "2021-12-04T14:50:48.000000Z"
            },
            "pickup_info": {
                "id": 1,
                "order_id": 1,
                "address": "Addressss",
                "longitude": "9.500000000000000",
                "latitude": "9.500000000000000",
                "time": "00:00:00",
                "date": "2021-09-17",
                "created_at": "2021-12-08T06:30:45.000000Z",
                "updated_at": "2021-12-08T06:30:45.000000Z"
            },
            "dropoff_locations": [
                {
                    "id": 1,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2021-12-08T06:30:45.000000Z",
                    "updated_at": "2021-12-08T06:30:45.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2021-12-04T14:50:48.000000Z",
                        "updated_at": "2021-12-04T14:50:48.000000Z"
                    }
                },
                {
                    "id": 2,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2021-12-08T06:30:45.000000Z",
                    "updated_at": "2021-12-08T06:30:45.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2021-12-04T14:50:48.000000Z",
                        "updated_at": "2021-12-04T14:50:48.000000Z"
                    }
                }
            ],
            "customer": {
                "id": 1,
                "user_id": 3,
                "customer_rating": null,
                "created_at": "2021-12-08T06:30:02.000000Z",
                "updated_at": "2021-12-08T06:30:20.000000Z",
                "verified": 1,
                "user": {
                    "id": 3,
                    "email": "customeremails@email.com",
                    "mobile_number": "09000000003",
                    "email_verified_at": null,
                    "created_at": "2021-12-08T06:30:02.000000Z",
                    "updated_at": "2021-12-08T06:30:02.000000Z",
                    "user_info": {
                        "id": 3,
                        "user_id": 3,
                        "first_name": "customerFirstNameUpdated",
                        "last_name": "customerLastNameUpdated",
                        "date_of_birth": "2021-12-30",
                        "profile_picture": null,
                        "created_at": "2021-12-08T06:30:02.000000Z",
                        "updated_at": "2021-12-08T06:30:20.000000Z",
                        "middle_name": null,
                        "country": null,
                        "province": null,
                        "city_municipality": null,
                        "postal_code": null,
                        "barangay": null,
                        "address": null
                    }
                }
            }
        }
    ]
}
// Driver Get Completed Order Ends

// Driver Get Cancelled Order Starts
let driver_response_cancelledOrder = {
    "message": "Ongoing orders.",
    "total_cancelled_orders": 1,
    "orders": [
        {
            "id": 1,
            "driver_id": 1,
            "completed_datetime": null,
            "order_status_id": 12,
            "total_mileage": 1,
            "instruction": null,
            "payment_method_id": 2,
            "total_amount": 1,
            "total_paid": 0,
            "total_due": 0,
            "holiday": 0,
            "high_demand": 0,
            "created_at": "2021-12-08T06:30:45.000000Z",
            "updated_at": "2021-12-08T06:32:45.000000Z",
            "area_id": 1,
            "customer_id": 1,
            "vehicle_id": 1,
            "order_status": {
                "id": 12,
                "status": "Cancelled",
                "created_at": "2021-12-04T14:50:48.000000Z",
                "updated_at": "2021-12-04T14:50:48.000000Z"
            },
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-12-04T14:50:48.000000Z",
                "updated_at": "2021-12-04T14:50:48.000000Z"
            },
            "pickup_info": {
                "id": 1,
                "order_id": 1,
                "address": "Addressss",
                "longitude": "9.500000000000000",
                "latitude": "9.500000000000000",
                "time": "00:00:00",
                "date": "2021-09-17",
                "created_at": "2021-12-08T06:30:45.000000Z",
                "updated_at": "2021-12-08T06:30:45.000000Z"
            },
            "dropoff_locations": [
                {
                    "id": 1,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2021-12-08T06:30:45.000000Z",
                    "updated_at": "2021-12-08T06:30:45.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2021-12-04T14:50:48.000000Z",
                        "updated_at": "2021-12-04T14:50:48.000000Z"
                    }
                },
                {
                    "id": 2,
                    "order_id": 1,
                    "longitude": "1.000000000000000",
                    "latitude": "1.000000000000000",
                    "name": "name1",
                    "contact": "contact1",
                    "address": "address1",
                    "instruction": "Instruction1",
                    "item_type_id": 7,
                    "created_at": "2021-12-08T06:30:45.000000Z",
                    "updated_at": "2021-12-08T06:30:45.000000Z",
                    "mileage": 1,
                    "landmark": "landmark1",
                    "item_type": {
                        "id": 7,
                        "type": "Others",
                        "created_at": "2021-12-04T14:50:48.000000Z",
                        "updated_at": "2021-12-04T14:50:48.000000Z"
                    }
                }
            ],
            "customer": {
                "id": 1,
                "user_id": 3,
                "customer_rating": null,
                "created_at": "2021-12-08T06:30:02.000000Z",
                "updated_at": "2021-12-08T06:30:20.000000Z",
                "verified": 1,
                "user": {
                    "id": 3,
                    "email": "customeremails@email.com",
                    "mobile_number": "09000000003",
                    "email_verified_at": null,
                    "created_at": "2021-12-08T06:30:02.000000Z",
                    "updated_at": "2021-12-08T06:30:02.000000Z",
                    "user_info": {
                        "id": 3,
                        "user_id": 3,
                        "first_name": "customerFirstNameUpdated",
                        "last_name": "customerLastNameUpdated",
                        "date_of_birth": "2021-12-30",
                        "profile_picture": null,
                        "created_at": "2021-12-08T06:30:02.000000Z",
                        "updated_at": "2021-12-08T06:30:20.000000Z",
                        "middle_name": null,
                        "country": null,
                        "province": null,
                        "city_municipality": null,
                        "postal_code": null,
                        "barangay": null,
                        "address": null
                    }
                }
            }
        }
    ]
}
// Driver Get Cancelled Order Ends

// Driver Assigned Order Starts
let driver_response_assignedOrder = {
    "message": "Order assigned.",
    "order": {
        "id": 1,
        "driver_id": 2,
        "completed_datetime": null,
        "order_status_id": 2,
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2021-10-18T13:55:01.000000Z",
        "updated_at": "2021-10-18T14:32:07.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "driver": null,
        "order_status": {
            "id": 2,
            "status": "Assigned",
            "created_at": "2021-10-18T13:45:44.000000Z",
            "updated_at": "2021-10-18T13:45:44.000000Z"
        },
        "payment_method": {
            "id": 2,
            "method": "Cash",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:53:12.000000Z",
            "verified": 1,
            "user": {
                "id": 1,
                "email": "customeremail@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-18T13:49:39.000000Z",
                "updated_at": "2021-10-18T13:49:39.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "customerFirstNameUpdated",
                    "last_name": "customerLastNameUpdated",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2021-10-18T13:49:39.000000Z",
                    "updated_at": "2021-10-18T13:53:12.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                }
            }
        },
        "vehicle": {
            "id": 1,
            "type": "Motorcycle",
            "max_weight_kg": 20,
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "dropoff_locations": [{
            "id": 1,
            "order_id": 1,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "samplename",
            "contact": "samplecontact",
            "address": "sampleadd",
            "instruction": "sampleInstruction",
            "item_type_id": 7,
            "created_at": "2021-10-18T13:55:02.000000Z",
            "updated_at": "2021-10-18T13:55:02.000000Z",
            "mileage": 1,
            "landmark": "samplelandmark"
        }]
    }
}
// Driver Assigned Order Ends
// Driver Update Order Starts
let driver_request_updateOrder = {
    "order_status_id": "12",
    "driver_id": "1"
}
let driver_response_updateOrder = {
    "message": "Order updated.",
    "order": {
        "id": 1,
        "driver_id": 2,
        "completed_datetime": null,
        "order_status_id": "12",
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2021-10-18T13:55:01.000000Z",
        "updated_at": "2021-10-18T14:34:01.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "order_status": {
            "id": 12,
            "status": "Cancelled",
            "created_at": "2021-10-18T13:45:44.000000Z",
            "updated_at": "2021-10-18T13:45:44.000000Z"
        },
        "payment_method": {
            "id": 2,
            "method": "Cash",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-10-18T13:49:39.000000Z",
            "updated_at": "2021-10-18T13:53:12.000000Z",
            "verified": 1,
            "user": {
                "id": 1,
                "email": "customeremail@email.com",
                "mobile_number": "09000000000",
                "email_verified_at": null,
                "created_at": "2021-10-18T13:49:39.000000Z",
                "updated_at": "2021-10-18T13:49:39.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "customerFirstNameUpdated",
                    "last_name": "customerLastNameUpdated",
                    "date_of_birth": "2021-12-30",
                    "profile_picture": null,
                    "created_at": "2021-10-18T13:49:39.000000Z",
                    "updated_at": "2021-10-18T13:53:12.000000Z",
                    "middle_name": null,
                    "country": null,
                    "province": null,
                    "city_municipality": null,
                    "postal_code": null,
                    "barangay": null,
                    "address": null
                }
            }
        },
        "vehicle": {
            "id": 1,
            "type": "Motorcycle",
            "max_weight_kg": 20,
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "dropoff_locations": [{
            "id": 1,
            "order_id": 1,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "samplename",
            "contact": "samplecontact",
            "address": "sampleadd",
            "instruction": "sampleInstruction",
            "item_type_id": 7,
            "created_at": "2021-10-18T13:55:02.000000Z",
            "updated_at": "2021-10-18T13:55:02.000000Z",
            "mileage": 1,
            "landmark": "samplelandmark"
        }]
    }
}
// Driver Update Orders Ends
// Driver Create pick up item image starts
let driver_request_pickupImage = {
    "driver_id": "1",
    "image": "(image type)",
    "dropoff_location_id": "1"
}
let driver_response_pickupImage = {
    "message": "Item image created.",
    "order": {
        "id": 2,
        "driver_id": 1,
        "completed_datetime": null,
        "order_status_id": 12,
        "total_mileage": 1,
        "instruction": null,
        "payment_method_id": 2,
        "total_amount": 1,
        "total_paid": 0,
        "total_due": 0,
        "holiday": 0,
        "high_demand": 0,
        "created_at": "2021-09-30T14:38:21.000000Z",
        "updated_at": "2021-10-04T12:57:51.000000Z",
        "area_id": 1,
        "customer_id": 1,
        "vehicle_id": 1,
        "dropoff_locations": [{
            "id": 2,
            "order_id": 2,
            "longitude": "9.500000000000000",
            "latitude": "9.500000000000000",
            "name": "username",
            "contact": "usercontact",
            "address": "useradd",
            "instruction": "userInstruction",
            "item_type_id": 7,
            "created_at": "2021-09-30T14:38:21.000000Z",
            "updated_at": "2021-09-30T14:38:21.000000Z",
            "mileage": 1,
            "landmark": "userlandmark"
        }],
        "pickup_item_images": [],
        "order_status": {
            "id": 12,
            "status": "Cancelled",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "payment_method": {
            "id": 2,
            "method": "Cash",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "area": {
            "id": 1,
            "description": "cebu",
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "customer": {
            "id": 1,
            "user_id": 1,
            "customer_rating": null,
            "created_at": "2021-09-30T08:09:02.000000Z",
            "updated_at": "2021-09-30T08:09:02.000000Z",
            "user": {
                "id": 1,
                "email": "email@email.com",
                "mobile_number": "09275652944",
                "email_verified_at": null,
                "created_at": "2021-09-30T08:09:02.000000Z",
                "updated_at": "2021-09-30T08:09:02.000000Z",
                "user_info": {
                    "id": 1,
                    "user_id": 1,
                    "first_name": "firstNames",
                    "last_name": "lastNames",
                    "date_of_birth": "1990-07-20",
                    "profile_picture": null,
                    "created_at": "2021-09-30T08:09:02.000000Z",
                    "updated_at": "2021-09-30T08:09:02.000000Z"
                }
            }
        },
        "vehicle": {
            "id": 1,
            "type": "Motorcycle",
            "max_weight_kg": 20,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        }
    }
}
// Driver Create pick up item image ends
// Driver Logout Starts
let driver_response_Logout = {
    "message": "Logged out."
}
// Driver Logout Ends
// Management Register Starts
let management_request_Register = {
    "first_name": "firstNameManagement",
    "last_name": "lastNameManagement",
    "mobile_number": "09999999999",
    "email": "managements@gmail.com",
    "password": "managementpassword",
    "date_of_birth": "1990-01-01",
    "management_role_id": "1",
}
let management_response_Register = {
    "message": "User created.",
    "user": {
        "mobile_number": "09999999999",
        "email": "managements@gmail.com",
        "updated_at": "2021-10-18T14:25:10.000000Z",
        "created_at": "2021-10-18T14:25:10.000000Z",
        "id": 5,
        "user_info": {
            "id": 5,
            "user_id": 5,
            "first_name": "firstNameManagement",
            "last_name": "lastNameManagement",
            "date_of_birth": "1990-01-01",
            "profile_picture": null,
            "created_at": "2021-10-18T14:25:10.000000Z",
            "updated_at": "2021-10-18T14:25:10.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        },
        "management": {
            "id": 1,
            "user_id": 5,
            "created_at": "2021-10-18T14:25:10.000000Z",
            "updated_at": "2021-10-18T14:25:10.000000Z",
            "management_role_id": 1,
            "management_role": {
                "id": 1,
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z",
                "role": "admin"
            }
        }
    },
    "token": "7|FfcJZF2zxk9zyVJVgIMbht9g0TrdlEic0R0RaYII"
}
// Management Register Ends
// Management Login Starts
let management_request_Login = {
    "account": "09999999999",
    "password": "managementpassword"
}
let management_response_Login = {
    "message": "Successfully login.",
    "user": {
        "id": 5,
        "email": "managements@gmail.com",
        "mobile_number": "09999999999",
        "email_verified_at": null,
        "created_at": "2021-10-18T14:25:10.000000Z",
        "updated_at": "2021-10-18T14:25:10.000000Z",
        "management": {
            "id": 1,
            "user_id": 5,
            "created_at": "2021-10-18T14:25:10.000000Z",
            "updated_at": "2021-10-18T14:25:10.000000Z",
            "management_role_id": 1,
            "management_role": {
                "id": 1,
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z",
                "role": "admin"
            }
        },
        "user_info": {
            "id": 5,
            "user_id": 5,
            "first_name": "firstNameManagement",
            "last_name": "lastNameManagement",
            "date_of_birth": "1990-01-01",
            "profile_picture": null,
            "created_at": "2021-10-18T14:25:10.000000Z",
            "updated_at": "2021-10-18T14:25:10.000000Z",
            "middle_name": null,
            "country": null,
            "province": null,
            "city_municipality": null,
            "postal_code": null,
            "barangay": null,
            "address": null
        }
    },
    "token": "8|TsxmzLmlD7XkTQJPG6Lnqtj7oeasyAAvF5o1Akmq"
}
// Management Login Ends
// Management Driver List Starts
let management_driversList = {
    "message": "Driver Lists",
    "drivers": [{
        "id": 1,
        "user_id": 2,
        "city": null,
        "driving_license_number": null,
        "driving_license_expiry": null,
        "driver_license_image": null,
        "driver_rating": null,
        "nbi_clearance": null,
        "status": 0,
        "number_of_fans": null,
        "vax_certificate": null,
        "created_at": "2021-10-18T13:59:39.000000Z",
        "updated_at": "2021-10-18T13:59:39.000000Z",
        "verification_status_id": 1,
        "operator_id": null,
        "verification_status": {
            "id": 1,
            "status": "Profile",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "user": {
            "id": 2,
            "email": "driversemail@gmail.com",
            "mobile_number": "09000000001",
            "email_verified_at": null,
            "created_at": "2021-10-18T13:59:39.000000Z",
            "updated_at": "2021-10-18T13:59:39.000000Z",
            "user_info": {
                "id": 2,
                "user_id": 2,
                "first_name": null,
                "last_name": null,
                "date_of_birth": null,
                "profile_picture": null,
                "created_at": "2021-10-18T13:59:39.000000Z",
                "updated_at": "2021-10-18T13:59:39.000000Z",
                "middle_name": null,
                "country": null,
                "province": null,
                "city_municipality": null,
                "postal_code": null,
                "barangay": null,
                "address": null
            }
        },
        "driver_vehicles": [],
        "operator": null
    },
    {
        "id": 2,
        "user_id": 3,
        "city": null,
        "driving_license_number": null,
        "driving_license_expiry": "2021-12-30",
        "driver_license_image": null,
        "driver_rating": null,
        "nbi_clearance": null,
        "status": 0,
        "number_of_fans": null,
        "vax_certificate": null,
        "created_at": "2021-10-18T14:01:08.000000Z",
        "updated_at": "2021-10-18T14:19:20.000000Z",
        "verification_status_id": 1,
        "operator_id": 1,
        "verification_status": {
            "id": 1,
            "status": "Profile",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "user": {
            "id": 3,
            "email": "driversemails@gmail.com",
            "mobile_number": "09000000002",
            "email_verified_at": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "user_info": {
                "id": 3,
                "user_id": 3,
                "first_name": "driverFirstNameUpdated",
                "last_name": "driverLastNameUpdated",
                "date_of_birth": "2021-12-30",
                "profile_picture": "BumbleeWallpaper_1634566760.jpg",
                "created_at": "2021-10-18T14:01:08.000000Z",
                "updated_at": "2021-10-18T14:19:20.000000Z",
                "middle_name": "driverMiddleNameUpdated",
                "country": null,
                "province": null,
                "city_municipality": null,
                "postal_code": null,
                "barangay": null,
                "address": null
            }
        },
        "driver_vehicles": [{
            "id": 1,
            "driver_id": 2,
            "vehicle_id": 1,
            "vehicle_brand": null,
            "vehicle_model": null,
            "vehicle_manufacture_year": null,
            "license_plate_number": null,
            "deed_of_sale": null,
            "vehicle_registration": null,
            "vehicle_front": null,
            "vehicle_side": null,
            "vehicle_back": null,
            "created_at": "2021-10-18T14:19:20.000000Z",
            "updated_at": "2021-10-18T14:19:20.000000Z",
            "vehicle": {
                "id": 1,
                "type": "Motorcycle",
                "max_weight_kg": 20,
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z",
                "vehicle_dimension": {
                    "id": 1,
                    "vehicle_id": 1,
                    "length_ft": 1.6,
                    "width_ft": 1.25,
                    "height_ft": 1.6,
                    "created_at": "2021-10-18T13:45:45.000000Z",
                    "updated_at": "2021-10-18T13:45:45.000000Z"
                },
                "vehicle_rates": [{
                    "id": 1,
                    "vehicle_id": 1,
                    "area_id": 1,
                    "base_fair": 15,
                    "charge_per_km": 8,
                    "per_add_stop": 30,
                    "created_at": "2021-10-18T13:45:45.000000Z",
                    "updated_at": "2021-10-18T13:45:45.000000Z",
                    "area": {
                        "id": 1,
                        "description": "cebu",
                        "created_at": "2021-10-18T13:45:45.000000Z",
                        "updated_at": "2021-10-18T13:45:45.000000Z"
                    }
                }]
            }
        }],
        "operator": {
            "id": 1,
            "user_id": 4,
            "operator_type_id": 1,
            "sponsor_code": "289500183954479",
            "valid_id_image": "(imageType).jpg",
            "sponsor_id": null,
            "created_at": "2021-10-18T14:18:19.000000Z",
            "updated_at": "2021-10-18T14:18:19.000000Z",
            "operator_type": {
                "id": 1,
                "type": "operator",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            }
        }
    }
    ]
}
// Management Driver List Ends
// Management Driver Show by ID Starts
let management_driverShowId = {
    "message": "Driver found.",
    "driver": {
        "id": 2,
        "user_id": 3,
        "city": null,
        "driving_license_number": null,
        "driving_license_expiry": "2021-12-30",
        "driver_license_image": null,
        "driver_rating": null,
        "nbi_clearance": null,
        "status": 0,
        "number_of_fans": null,
        "vax_certificate": null,
        "created_at": "2021-10-18T14:01:08.000000Z",
        "updated_at": "2021-10-18T14:19:20.000000Z",
        "verification_status_id": 1,
        "operator_id": 1,
        "verification_status": {
            "id": 1,
            "status": "Profile",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "user": {
            "id": 3,
            "email": "driversemails@gmail.com",
            "mobile_number": "09000000002",
            "email_verified_at": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "user_info": {
                "id": 3,
                "user_id": 3,
                "first_name": "driverFirstNameUpdated",
                "last_name": "driverLastNameUpdated",
                "date_of_birth": "2021-12-30",
                "profile_picture": "BumbleeWallpaper_1634566760.jpg",
                "created_at": "2021-10-18T14:01:08.000000Z",
                "updated_at": "2021-10-18T14:19:20.000000Z",
                "middle_name": "driverMiddleNameUpdated",
                "country": null,
                "province": null,
                "city_municipality": null,
                "postal_code": null,
                "barangay": null,
                "address": null
            }
        },
        "driver_vehicles": [{
            "id": 1,
            "driver_id": 2,
            "vehicle_id": 1,
            "vehicle_brand": null,
            "vehicle_model": null,
            "vehicle_manufacture_year": null,
            "license_plate_number": null,
            "deed_of_sale": null,
            "vehicle_registration": null,
            "vehicle_front": null,
            "vehicle_side": null,
            "vehicle_back": null,
            "created_at": "2021-10-18T14:19:20.000000Z",
            "updated_at": "2021-10-18T14:19:20.000000Z",
            "vehicle": {
                "id": 1,
                "type": "Motorcycle",
                "max_weight_kg": 20,
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z",
                "vehicle_dimension": {
                    "id": 1,
                    "vehicle_id": 1,
                    "length_ft": 1.6,
                    "width_ft": 1.25,
                    "height_ft": 1.6,
                    "created_at": "2021-10-18T13:45:45.000000Z",
                    "updated_at": "2021-10-18T13:45:45.000000Z"
                },
                "vehicle_rates": [{
                    "id": 1,
                    "vehicle_id": 1,
                    "area_id": 1,
                    "base_fair": 15,
                    "charge_per_km": 8,
                    "per_add_stop": 30,
                    "created_at": "2021-10-18T13:45:45.000000Z",
                    "updated_at": "2021-10-18T13:45:45.000000Z",
                    "area": {
                        "id": 1,
                        "description": "cebu",
                        "created_at": "2021-10-18T13:45:45.000000Z",
                        "updated_at": "2021-10-18T13:45:45.000000Z"
                    }
                }]
            }
        }],
        "operator": {
            "id": 1,
            "user_id": 4,
            "operator_type_id": 1,
            "sponsor_code": "289500183954479",
            "valid_id_image": "(imageType).jpg",
            "sponsor_id": null,
            "created_at": "2021-10-18T14:18:19.000000Z",
            "updated_at": "2021-10-18T14:18:19.000000Z",
            "operator_type": {
                "id": 1,
                "type": "operator",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            }
        }
    }
}
// Management Driver Show by ID Ends
// Management Driver Verification Update Starts
let management_request_driverVerificationUpdate = {
    "verification_status_id": "9"
}
let management_response_driverVerificationUpdate = {
    "message": "Verification status successfully updated.",
    "driver": {
        "id": 2,
        "user_id": 3,
        "city": null,
        "driving_license_number": null,
        "driving_license_expiry": "2021-12-30",
        "driver_license_image": null,
        "driver_rating": null,
        "nbi_clearance": null,
        "status": 0,
        "number_of_fans": null,
        "vax_certificate": null,
        "created_at": "2021-10-18T14:01:08.000000Z",
        "updated_at": "2021-10-18T14:29:50.000000Z",
        "verification_status_id": "9",
        "operator_id": 1,
        "verification_status": {
            "id": 9,
            "status": "Verified",
            "created_at": "2021-10-18T13:45:45.000000Z",
            "updated_at": "2021-10-18T13:45:45.000000Z"
        },
        "user": {
            "id": 3,
            "email": "driversemails@gmail.com",
            "mobile_number": "09000000002",
            "email_verified_at": null,
            "created_at": "2021-10-18T14:01:08.000000Z",
            "updated_at": "2021-10-18T14:01:08.000000Z",
            "user_info": {
                "id": 3,
                "user_id": 3,
                "first_name": "driverFirstNameUpdated",
                "last_name": "driverLastNameUpdated",
                "date_of_birth": "2021-12-30",
                "profile_picture": "BumbleeWallpaper_1634566760.jpg",
                "created_at": "2021-10-18T14:01:08.000000Z",
                "updated_at": "2021-10-18T14:19:20.000000Z",
                "middle_name": "driverMiddleNameUpdated",
                "country": null,
                "province": null,
                "city_municipality": null,
                "postal_code": null,
                "barangay": null,
                "address": null
            }
        },
        "driver_vehicles": [{
            "id": 1,
            "driver_id": 2,
            "vehicle_id": 1,
            "vehicle_brand": null,
            "vehicle_model": null,
            "vehicle_manufacture_year": null,
            "license_plate_number": null,
            "deed_of_sale": null,
            "vehicle_registration": null,
            "vehicle_front": null,
            "vehicle_side": null,
            "vehicle_back": null,
            "created_at": "2021-10-18T14:19:20.000000Z",
            "updated_at": "2021-10-18T14:19:20.000000Z",
            "vehicle": {
                "id": 1,
                "type": "Motorcycle",
                "max_weight_kg": 20,
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z",
                "vehicle_dimension": {
                    "id": 1,
                    "vehicle_id": 1,
                    "length_ft": 1.6,
                    "width_ft": 1.25,
                    "height_ft": 1.6,
                    "created_at": "2021-10-18T13:45:45.000000Z",
                    "updated_at": "2021-10-18T13:45:45.000000Z"
                },
                "vehicle_rates": [{
                    "id": 1,
                    "vehicle_id": 1,
                    "area_id": 1,
                    "base_fair": 15,
                    "charge_per_km": 8,
                    "per_add_stop": 30,
                    "created_at": "2021-10-18T13:45:45.000000Z",
                    "updated_at": "2021-10-18T13:45:45.000000Z",
                    "area": {
                        "id": 1,
                        "description": "cebu",
                        "created_at": "2021-10-18T13:45:45.000000Z",
                        "updated_at": "2021-10-18T13:45:45.000000Z"
                    }
                }]
            }
        }],
        "operator": {
            "id": 1,
            "user_id": 4,
            "operator_type_id": 1,
            "sponsor_code": "289500183954479",
            "valid_id_image": "johnson-optimus-prime-transormers-skin-mlbb-4k-wallpaper-3840x2160-uhdpaper.com-787.0_b_1634566699.jpg",
            "sponsor_id": null,
            "created_at": "2021-10-18T14:18:19.000000Z",
            "updated_at": "2021-10-18T14:18:19.000000Z",
            "operator_type": {
                "id": 1,
                "type": "operator",
                "created_at": "2021-10-18T13:45:45.000000Z",
                "updated_at": "2021-10-18T13:45:45.000000Z"
            }
        }
    }
}
// Management Driver Verification Update Ends
// Management Logout Starts
let management_request_Logout = {
    "authentication": "Bearer <12|Pb94DrhkfYt909MBffqnqczE8Zcl4jI83UlfbSO7>"
}
let management_response_Logout = {
    "message": "Logged out."
}
// Management Logout Ends
// Dropdown VehicleType Starts
let dropdown_vehicleType = {
    "message": "Vehicle Lists",
    "vehicle": [{
        "id": 1,
        "type": "Motorcycle",
        "max_weight_kg": 20,
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "vehicle_dimension": {
            "id": 1,
            "vehicle_id": 1,
            "length_ft": 1.6,
            "width_ft": 1.25,
            "height_ft": 1.6,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "vehicle_rates": [{
            "id": 1,
            "vehicle_id": 1,
            "area_id": 1,
            "base_fair": 15,
            "charge_per_km": 8,
            "per_add_stop": 30,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }]
    },
    {
        "id": 2,
        "type": "200 kg Sedan",
        "max_weight_kg": 200,
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "vehicle_dimension": {
            "id": 2,
            "vehicle_id": 2,
            "length_ft": 3.2,
            "width_ft": 1.9,
            "height_ft": 2.3,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "vehicle_rates": [{
            "id": 2,
            "vehicle_id": 2,
            "area_id": 1,
            "base_fair": 120,
            "charge_per_km": 18,
            "per_add_stop": 45,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }]
    },
    {
        "id": 3,
        "type": "300 kg MPV",
        "max_weight_kg": 300,
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "vehicle_dimension": {
            "id": 3,
            "vehicle_id": 3,
            "length_ft": 4,
            "width_ft": 3.2,
            "height_ft": 2.8,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "vehicle_rates": [{
            "id": 3,
            "vehicle_id": 3,
            "area_id": 1,
            "base_fair": 145,
            "charge_per_km": 20,
            "per_add_stop": 60,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }]
    },
    {
        "id": 4,
        "type": "600kg MPV",
        "max_weight_kg": 600,
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "vehicle_dimension": {
            "id": 4,
            "vehicle_id": 4,
            "length_ft": 7,
            "width_ft": 4,
            "height_ft": 3.5,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "vehicle_rates": [{
            "id": 4,
            "vehicle_id": 4,
            "area_id": 1,
            "base_fair": 250,
            "charge_per_km": 25,
            "per_add_stop": 60,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }]
    },
    {
        "id": 5,
        "type": "FB/L300",
        "max_weight_kg": 1000,
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "vehicle_dimension": {
            "id": 5,
            "vehicle_id": 5,
            "length_ft": 7,
            "width_ft": 4,
            "height_ft": 4,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z"
        },
        "vehicle_rates": [{
            "id": 5,
            "vehicle_id": 5,
            "area_id": 1,
            "base_fair": 430,
            "charge_per_km": 30,
            "per_add_stop": 80,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "area": {
                "id": 1,
                "description": "cebu",
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z"
            }
        }]
    }
    ]
}
// Dropdown VehicleType Ends
// Dropdown VehicleAreas Starts
let dropdown_vehicleAreas = {
    "message": "Vehicle Areas",
    "areas": [{
        "id": 1,
        "description": "cebu",
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "vehicle_rates": [{
            "id": 1,
            "vehicle_id": 1,
            "area_id": 1,
            "base_fair": 15,
            "charge_per_km": 8,
            "per_add_stop": 30,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle": {
                "id": 1,
                "type": "Motorcycle",
                "max_weight_kg": 20,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z",
                "vehicle_dimension": {
                    "id": 1,
                    "vehicle_id": 1,
                    "length_ft": 1.6,
                    "width_ft": 1.25,
                    "height_ft": 1.6,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }
        },
        {
            "id": 2,
            "vehicle_id": 2,
            "area_id": 1,
            "base_fair": 120,
            "charge_per_km": 18,
            "per_add_stop": 45,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle": {
                "id": 2,
                "type": "200 kg Sedan",
                "max_weight_kg": 200,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z",
                "vehicle_dimension": {
                    "id": 2,
                    "vehicle_id": 2,
                    "length_ft": 3.2,
                    "width_ft": 1.9,
                    "height_ft": 2.3,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }
        },
        {
            "id": 3,
            "vehicle_id": 3,
            "area_id": 1,
            "base_fair": 145,
            "charge_per_km": 20,
            "per_add_stop": 60,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle": {
                "id": 3,
                "type": "300 kg MPV",
                "max_weight_kg": 300,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z",
                "vehicle_dimension": {
                    "id": 3,
                    "vehicle_id": 3,
                    "length_ft": 4,
                    "width_ft": 3.2,
                    "height_ft": 2.8,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }
        },
        {
            "id": 4,
            "vehicle_id": 4,
            "area_id": 1,
            "base_fair": 250,
            "charge_per_km": 25,
            "per_add_stop": 60,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle": {
                "id": 4,
                "type": "600kg MPV",
                "max_weight_kg": 600,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z",
                "vehicle_dimension": {
                    "id": 4,
                    "vehicle_id": 4,
                    "length_ft": 7,
                    "width_ft": 4,
                    "height_ft": 3.5,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }
        },
        {
            "id": 5,
            "vehicle_id": 5,
            "area_id": 1,
            "base_fair": 430,
            "charge_per_km": 30,
            "per_add_stop": 80,
            "created_at": "2021-09-30T07:45:38.000000Z",
            "updated_at": "2021-09-30T07:45:38.000000Z",
            "vehicle": {
                "id": 5,
                "type": "FB/L300",
                "max_weight_kg": 1000,
                "created_at": "2021-09-30T07:45:38.000000Z",
                "updated_at": "2021-09-30T07:45:38.000000Z",
                "vehicle_dimension": {
                    "id": 5,
                    "vehicle_id": 5,
                    "length_ft": 7,
                    "width_ft": 4,
                    "height_ft": 4,
                    "created_at": "2021-09-30T07:45:38.000000Z",
                    "updated_at": "2021-09-30T07:45:38.000000Z"
                }
            }
        }
        ]
    }]
}
// Dropdown VehicleAreas Ends
// Dropdown MangementRole Starts
let dropdown_ManagementRole = {
    "message": "List of Management Role",
    "total_management_roles": 1,
    "management_role": [{
        "id": 1,
        "created_at": "2021-09-30T07:45:38.000000Z",
        "updated_at": "2021-09-30T07:45:38.000000Z",
        "role": "admin"
    }]
}
// Dropdown ManagementRole Ends

// Customer Starts
document.getElementById('customer_request_OTP').textContent = JSON.stringify(customer_request_OTP, undefined,
    2);
document.getElementById('customer_response_OTP').textContent = JSON.stringify(customer_response_OTP, undefined,
    2);
document.getElementById('customer_request_otpVerify').textContent = JSON.stringify(customer_request_otpVerify,
    undefined, 2);
document.getElementById('customer_response_otpVerify').textContent =
    JSON.stringify(customer_response_otpVerify, undefined, 2);
document.getElementById('customer_request_registration').textContent =
    JSON.stringify(customer_request_registration, undefined, 2);
document.getElementById('customer_response_registration ').textContent = JSON.stringify(
    customer_response_registration,
    undefined, 2);
document.getElementById('customer_request_login').textContent = JSON.stringify(customer_request_login,
    undefined, 2);
document.getElementById('customer_response_login').textContent = JSON.stringify(
    customer_response_login, undefined, 2);
document.getElementById('customer_response_profile').textContent = JSON.stringify(customer_response_profile,
    undefined, 2);
document.getElementById('customer_request_profileUpdate').textContent = JSON.stringify(
    customer_request_profileUpdate, undefined, 2);
document.getElementById('customer_response_profileUpdate').textContent = JSON.stringify(
    customer_response_profileUpdate, undefined, 2);
document.getElementById('customer_request_createOrder').textContent = JSON.stringify(
    customer_request_createOrder,
    undefined, 2);
document.getElementById('customer_response_createOrder').textContent = JSON.stringify(
    customer_response_createOrder,
    undefined, 2);

document.getElementById('customer_response_updateOrder').textContent = JSON.stringify(
    customer_response_updateOrder,
    undefined, 2);
document.getElementById('customer_response_getOrderOngoing').textContent = JSON.stringify(
    customer_response_getOrderOngoing,
    undefined,
    2);
document.getElementById('customer_response_getOrderCompleted').textContent = JSON.stringify(
    customer_response_getOrderCompleted,
    undefined,
    2);

document.getElementById('customer_response_getOrderCancelled').textContent = JSON.stringify(
    customer_response_getOrderCancelled,
    undefined,
    2);
document.getElementById('customer_response_logout').textContent = JSON.stringify(customer_response_logout,
    undefined, 2);
// Customer Ends
// Driver Starts
document.getElementById('driver_request_OTP').textContent = JSON.stringify(driver_request_OTP, undefined, 2);
document.getElementById('driver_response_OTP').textContent = JSON.stringify(driver_response_OTP, undefined, 2);
document.getElementById('driver_request_otpVerify').textContent = JSON.stringify(driver_request_otpVerify,
    undefined, 2);
document.getElementById('driver_response_otpVerify').textContent = JSON.stringify(driver_response_otpVerify,
    undefined, 2);
document.getElementById('driver_request_Register').textContent = JSON.stringify(driver_request_Register,
    undefined,
    2);
document.getElementById('driver_response_Register').textContent = JSON.stringify(driver_response_Register,
    undefined, 2);
document.getElementById('driver_request_Login').textContent = JSON.stringify(driver_request_Login, undefined,
    2);
document.getElementById('driver_response_Login').textContent = JSON.stringify(driver_response_Login, undefined,
    2);
document.getElementById('driver_response_profile').textContent = JSON.stringify(driver_response_profile,
    undefined,
    2);
document.getElementById('driver_request_profileUpdate').textContent =
    JSON.stringify(driver_request_profileUpdate,
        undefined, 2);
document.getElementById('driver_response_profileUpdate').textContent =
    JSON.stringify(driver_response_profileUpdate,
        undefined, 2);
document.getElementById('driver_response_vehicles').textContent =
    JSON.stringify(driver_response_vehicles,
        undefined, 2);

document.getElementById('driver_request_vehicleUpdate').textContent =
    JSON.stringify(driver_request_vehicleUpdate,
        undefined, 2);
document.getElementById('driver_response_vehicleUpdate').textContent =
    JSON.stringify(driver_response_vehicleUpdate,
        undefined, 2);
document.getElementById('driver_request_vehicleCreate').textContent =
    JSON.stringify(driver_request_vehicleCreate,
        undefined, 2);
document.getElementById('driver_response_vehicleCreate').textContent =
    JSON.stringify(driver_response_vehicleCreate,
        undefined, 2);
document.getElementById('driver_response_getOrderAvailable').textContent = JSON.stringify(
    driver_response_getOrderAvailable,
    undefined,
    2);
document.getElementById('driver_response_ongoingOrder').textContent =
    JSON.stringify(driver_response_ongoingOrder,
        undefined, 2);

document.getElementById('driver_response_completedOrder').textContent =
    JSON.stringify(driver_response_completedOrder,
        undefined, 2);

document.getElementById('driver_response_cancelledOrder').textContent =
    JSON.stringify(driver_response_cancelledOrder,
        undefined, 2);

document.getElementById('driver_response_assignedOrder').textContent =
    JSON.stringify(driver_response_assignedOrder,
        undefined,
        2);
document.getElementById('driver_request_updateOrder').textContent = JSON.stringify(driver_request_updateOrder,
    undefined, 2);
document.getElementById('driver_response_updateOrder').textContent = JSON.stringify(driver_response_updateOrder,
    undefined, 2);
document.getElementById('driver_request_pickupImage').textContent = JSON.stringify(driver_request_pickupImage,
    undefined, 2);
document.getElementById('driver_response_pickupImage').textContent = JSON.stringify(driver_response_pickupImage,
    undefined, 2);
document.getElementById('driver_response_Logout').textContent = JSON.stringify(driver_response_Logout,
    undefined,
    2);
// Driver Ends
// Management Starts
document.getElementById('management_request_Register').textContent = JSON.stringify(management_request_Register,
    undefined, 2);
document.getElementById('management_response_Register').textContent =
    JSON.stringify(management_response_Register,
        undefined, 2);
document.getElementById('management_request_Login').textContent = JSON.stringify(management_request_Login,
    undefined, 2);
document.getElementById('management_response_Login').textContent = JSON.stringify(management_response_Login,
    undefined, 2);
document.getElementById('management_response_Logout').textContent = JSON.stringify(management_response_Logout,
    undefined, 2);
document.getElementById('management_driversList').textContent = JSON.stringify(management_driversList,
    undefined, 2);
document.getElementById('management_driverShowId').textContent = JSON.stringify(management_driverShowId,
    undefined, 2);
document.getElementById('management_request_driverVerificationUpdate').textContent = JSON.stringify(
    management_request_driverVerificationUpdate,
    undefined, 2);
document.getElementById('management_response_driverVerificationUpdate').textContent = JSON.stringify(
    management_response_driverVerificationUpdate,
    undefined, 2);
// Management Ends
// Dropdown Starts
document.getElementById('dropdown_vehicleType').textContent = JSON.stringify(dropdown_vehicleType,
    undefined, 2);
document.getElementById('dropdown_vehicleAreas').textContent = JSON.stringify(dropdown_vehicleAreas,
    undefined, 2);
document.getElementById('dropdown_ManagementRole').textContent = JSON.stringify(dropdown_ManagementRole,
    undefined, 2);
// Dropdown Ends
