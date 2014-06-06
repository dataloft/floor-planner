
    <div class="container">
        <footer>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Company 2013</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.container -->

    <!-- JavaScript -->
    <script src="/themes/startbootstrap/js/jquery-1.10.2.js"></script>
    <script src="/themes/startbootstrap/js/bootstrap.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
    

<?
if (!empty($counters))
    echo $counters->text;
?>
    
    
</body>

</html>