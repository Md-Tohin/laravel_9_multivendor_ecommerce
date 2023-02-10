@if (count($deliveryAddresses) > 0)
    <h4 class="section-h4">Delivery Addresses</h4>
    @foreach ($deliveryAddresses as $address)
        <div class="control-group" style="float: left; margin-right: 5px;">
            <input type="radio" id="address{{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}">
        </div>
        <div>
            <label for="" class="control-label"> {{ $address['name'] }}, {{ $address['address'] }}, {{ $address['city'] }},<br> 
            {{ $address['state'] }}, {{ $address['country'] }} ({{ $address['mobile'] }})</label>
            <a href="javascript:void(0)" class="removeAddress" data-addressid="{{ $address['id'] }}" style="float: right; margin-left: 10px;">Remove</a>
            <a href="javascript:void(0)" class="editAddress" data-addressid="{{ $address['id'] }}" style="float: right;">Edit</a>
        </div>
    @endforeach
    <br>
@endif
<h4 class="section-h4 deliveryText">Add New Delivery Address</h4>
<div class="u-s-m-b-24 newAddress">
    <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse"
        data-target="#showdifferent">
    <label class="label-text" for="ship-to-different-address">Ship to a different address?</label>
</div>
<div class="collapse" id="showdifferent">
    <!-- Form-Fields -->
    <form action="javascript:void(0);" method="POST" id="addressAddEditForm">
        @csrf
        <input type="hidden" name="delivery_id">
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="first-name-extra">Name
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_name" name="delivery_name" class="text-field" placeholder="Enter Name">
                <p><small id="delivery-delivery_name"></small></p>
            </div>
            <div class="group-2">
                <label for="last-name-extra">Mobile
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_mobile" name="delivery_mobile" placeholder="Enter Mobile" class="text-field">
                <p><small id="delivery-delivery_mobile"></small></p>
            </div>
        </div>
        <div class="u-s-m-b-13">
            <label for="first-name-extra">Address
                <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_address" name="delivery_address" placeholder="Enter Address" class="text-field">     
            <p><small id="delivery-delivery_address"></small></p>       
        </div>
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="last-name-extra">City
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_city" name="delivery_city" placeholder="Enter City" class="text-field">
                <p><small id="delivery-delivery_city"></small></p>
            </div>
            <div class="group-2">                
                <label for="first-name-extra">State
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_state" name="delivery_state" placeholder="Enter State" class="text-field">
                <p><small id="delivery-delivery_state"></small></p>
            </div>
            
        </div>
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="select-country-extra">Country
                    <span class="astk">*</span>
                </label>
                <div class="select-box-wrapper">                
                    <select name="delivery_country" id="country" class="select-box">
                        <option selected="selected" value="">Choose your country...</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country->country_name }}" @if ($country['country_name'] == $address['country']) selected @endif>{{ $country->country_name }}</option>
                        @endforeach
                    </select>
                </div>
                <p><small id="delivery-delivery_country"></small></p>
            </div>
            <div class="group-2">
                <label for="last-name-extra">Pincode
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_pincode" name="delivery_pincode" placeholder="Enter Pincode" class="text-field">
                <p><small id="delivery-delivery_pincode"></small></p>
            </div>
        </div>
        <div class="m-b-45" style="margin-top: 25px;">
            <button type="submit" class="button button-outline-secondary w-100">Save</button>
        </div>
    </form>    
    <!-- Form-Fields /- -->
</div>
<br>
<div>
    <label for="order-notes">Order Notes</label>
    <textarea class="text-area" id="order-notes"
        placeholder="Notes about your order, e.g. special notes for delivery." name="order_note"></textarea>
</div>