<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="area">Area</label>
                    <select class="form-control" id="area" name="area">
                        <option>-Select Area-</option>               
                        @foreach($area as $a)
                        <option value="{{$a->id}}">{{$a->name}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account Name</label>
                    <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Account Name">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Phone Number</label>
                    <input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Phone Number">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">ID Number</label>
                    <input type="number" class="form-control" id="national_id" name="national_id" placeholder="ID Number">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Plot Number</label>
                    <input type="text" class="form-control" id="plot_number" name="plot_number" placeholder="Plot Number">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Account Open Date</label>
                    <input type="text" class="form-control datepicker" id="account_open_date" name="account_open_date" data-date-format="DD MMMM YYYY" placeholder="Account Open Date">
                </div>
            </div>            <div class="col-6">              
                <div class="form-group">
                    <label for="exampleFormControlInput1">Meter Number</label>
                    <input type="text" class="form-control" id="meter_number" name="meter_number" placeholder="Meter Number">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlSelect2">Account Status</label>
                    <select  class="form-control" id="status" name="status">
                        <option>-Select Status-</option>               
                        @foreach($status as $a)
                        <option value="{{$a->id}}">{{$a->status}}</option>
                        @endforeach
                    </select>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Avatar">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Connection Date</label>
                    <input type="text" class="form-control datepicker" id="connection_date" name="connection_date" placeholder="Connection Date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Vacation Date</label>
                    <input type="text" class="form-control datepicker" id="vaccation_date" name="vaccation_date" placeholder="Vacation Date">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Reconnection Date</label>
                    <input type="text" class="form-control datepicker" id="reconnection_date" name="reconnection_date" placeholder="Reconnection Date">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Meter Reading Date</label>
                    <input type="date" class="form-control" id="meter_reading_date" name="meter_reading_date" placeholder="Meter Reading Date">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Comments</label>
                    <textarea class="form-control" id="comment" name="comment" placeholder="Any Comment" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-md btn-primary" id="submit" value="Submit"/>
                </div>
            </div>

        </div>


    </div>
</div>