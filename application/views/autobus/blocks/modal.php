<!-- Modal -->
<div class="modal contact-page fade booking-form" id="booking-form" tabindex="-1" role="dialog" aria-labelledby="booking-form">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3>Send message for Booking: </h3>
                <form class="contact-form search-form-box" action="inc/booking-form.php">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Name <span>*</span></label>
                                <input type="text" name="name" placeholder="Enter your name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Email <span>*</span></label>
                                <input type="text" name="email" placeholder="Enter your email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Phone <span>*</span></label>
                                <input type="text" name="phone" placeholder="Enter your phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Try Trip: <span>*</span></label>
                                <select name="trip" class="select-input">
                                    <option value="#">Per Hour</option>
                                    <option value="#">Per Day</option>
                                    <option value="#">Airport Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Vehicle: <span>*</span></label>
                                <select name="vehicle" class="select-input">
                                    <option value="Black Lincoln MKT">Black Lincoln MKT</option>
                                    <option value="Black Lincoln Sedan">Black Lincoln Sedan</option>
                                    <option value="Mercedes Grand Sedan">Mercedes Grand Sedan</option>
                                    <option value="Black Cadillac Sedan">Black Cadillac Sedan</option>
                                    <option value="Cadillac Escalade Limo">Cadillac Escalade Limo</option>
                                    <option value="Lincoln Stretch Limo">Lincoln Stretch Limo</option>
                                    <option value="Hummer Strecth Limo">Hummer Strecth Limo</option>
                                    <option value="Ford Party Bus Limo">Ford Party Bus Limo</option>
                                    <option value="Mercedes Party Limo">Mercedes Party Limo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Pickup Date: <span>*</span></label>
                                <input type="text" name="date" placeholder="MM/DD/YYYY" class="date-picker">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="col-md-12">
                            <div class="form-grp">
                                <label>Number of Passenger <span>*</span></label>
                                <input type="text" name="passenger" placeholder="xxxxxxx">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Pickup Location <span>*</span></label>
                                <textarea name="pickup" placeholder="Enter Your message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-grp">
                                <label>Destination <span>*</span></label>
                                <textarea name="destination" placeholder="Enter Your message"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 clearfix">
                            <label>Additional Note <span>*</span></label>
                            <textarea name="message" placeholder="Enter Your message"></textarea>
                            <button type="submit" class="pull-right thm-btn hvr-sweep-to-top">SEND MESSAGE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>