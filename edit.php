<div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">Name</label>
                                            <div class="col-md-8">
                                                <input type="text" name="user_name" id="user_name" class="form-control" value="<?=$row['user_name']; ?>">
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">Gender</label>
                                            <div class="col-md-8">
                                                    <select name="user_gender"  id="user_gender" class="form-control">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>

                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">Addresse</label>
                                            <div class="col-md-8">
                                                <input type="text" name="user_address" id="user_address" class="form-control" value="<?=$row['user_address']; ?>">
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">City</label>
                                            <div class="col-md-8">
                                                <input type="text" name="user_city" id="user_city" class="form-control" value="<?=$row['user_city']; ?>">
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">Zip Colde</label>
                                            <div class="col-md-8">
                                                <input type="text" name="user_zipcode" id="user_zipcode" class="form-control" value="<?=$row['user_zipcode']; ?>">
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">State</label>
                                            <div class="col-md-8">
                                                <input type="text" name="user_state" id="user_state" class="form-control" value="<?=$row['user_state']; ?>">
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-md-4" align="right">Country</label>
                                            <div class="col-md-8">
                                                <select name="user_country" id="user_country" class="form-control">
                                                    <option value="">Select Country</option>
                                                    <?php
                                                    echo load_country_list(); 
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                    <div class="row">
                                            <label class="col-md-4" align="right">Profile</label>
                                            <div class="col-md-8">
                                            <input type="file" name="user_avatar">
                                            <br>
                                                <?php

                                                    Get_user_avatar($row["register_user_id"],$connect);
                                                ?>
                                                <br>
                                                <input type="hidden" name="hidden_user_avatar" value="<?php echo $row['user_avatar']; ?>">
                                                <br>

                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="register_user_id" value="<?php echo $row["register_user_id"];?>">
                                        <input type="submit" name="edit" class="btn btn-primary" Value="edit">

                                    </div>
