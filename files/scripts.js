function enrollFunction(action) {
    if (action == 0) {
        let wantLogin = confirm("You must be a student to enroll on this course, want to log in as a student?");
        if(wantLogin) location.href = "/Learning-Academy/close.php";
    } else if (action == 1) {
        let confirmEnroll = confirm("You want to enroll on this course?");
        if(confirmEnroll) {
            alert("You enrolled correctly to this couse!");
        }
    }
}