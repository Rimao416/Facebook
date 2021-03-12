<?php
    include('header.php')
?>
<style>
    [contenteditable]{
        outline:0px solid transparent;
        min-height:100px;
        height:auto;
        cursor:auto;
        font-size:24px;
    }
    [contenteditable]:empty:before{
        content:attr(placeholder);
        color:#ccc;
        cursor:auto;
    }
    [placeholder]:empty:focus:before{
        content:'';

    }

</style>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
            <form method="post" id="post_form">
                <div class="panel panel-default" style="border:1px solid #D8D8D8;">
                    <div class="panel-heading" style="background-color:	#D8D8D8;">
                        <h3 class="panel-title"> Create Post</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="btn btn-success btn-xs fileinput-button">
                            <span>
                                Add Files...
                            </span>
                            <input type="file" name="files[]" id="multiple_files" multiple>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div name="content_area" id="content_area" contenteditable="true" placeholder="Write Something">
                        
                        </div>
                    </div>
                    <div class="panel-footer" align="right">
                    <input type="hidden" name="action" id="action" value="create">
                        <button type="submit" name="share_button" id="share_button" class="btn btn-primary btn-sm">Post</button>
                    </div>
                </div>
                </form>
                <br>
                <div id="timeline_area">
                
                </div>
            </div>
            <div class="col-md-3">
            <div class="panel panel-default" style="border:1px solid #D8D8D8;">
                    <div class="panel-heading" style="background-color:	#D8D8D8;">
                        Friends
                        
                    </div>
                    <br>
                <div class="col-xs-6">
                    <input type="text" name="search_friend" id="search_friend" class="form-control input-sm" placeholder="Search"/>
                </div>
                <div class="panel-body">
                            <div id="friends_list">

                            </div>
                </div>
            </div>

            </div>
        </div>

    </div>
<?php include 'footer.php'?>