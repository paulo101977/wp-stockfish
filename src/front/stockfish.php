<?php
  $front_full_path  = plugins_url() . '/wp-stockfish/src/front/';
  $widget_full_path  = plugins_url() . '/wp-stockfish/src/widget/';
?>

<div class="board-container">
  <link rel="stylesheet" href="<?php echo $front_full_path;?>css/style.css">
  <link rel="stylesheet" href="<?php echo $front_full_path;?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $front_full_path;?>css/chessboard-0.3.0.min.css" />
  <script src="<?php echo $front_full_path;?>js/jquery-1.10.1.min.js"></script>
  <script src="<?php echo $front_full_path;?>js/bootstrap.min.js"></script>
  <script src="<?php echo $front_full_path;?>js/chess.min.js"></script>
  <script src="<?php echo $front_full_path;?>js/chessboard-0.3.0.min.js"></script>
  <div class="row">
    <div class="col-sm-7 col-md-6">
      <span class="h3" id="time1">0:05:00</span>
      <div id="board" class="chess-board"></div>
      <span class="h3" id="time2">0:05:00</span>
      <hr>
      <div id="engineStatus">...</div>
    </div>
    <div class="col-sm-5 col-md-6">
      <h3>Moves:</h3>
      <div id="pgn"></div>
      <hr>
      <!-- form -->
      <?php include("form.php"); ?>

      <h5>Evaluation</h5>
      <pre id=evaluation></pre>
  </div>
  <script src="<?php echo $front_full_path;?>enginegame.js"></script>
  <script src="<?php echo $front_full_path;?>stockfish.js"></script>
  <script>
    var wait_for_script = false;
    var newGame = function (){};
    
    /// We can load Stockfish.js via Web Workers or directly via a <script> tag.
    /// Web Workers are better since they don't block the UI, but they are not always avaiable.
    (function fix_workers()
    {
      var script_tag;
      /// Does the environment support web workers?  If not, include stockfish.js directly.
      ///NOTE: Since web workers don't work when a page is loaded from the local system, we have to fake it there too. (Take that security measures!)
      if (!Worker || (location && location.protocol === "file:")) {
        var script_tag  = document.createElement("script");
        script_tag.type ="text/javascript";
        script_tag.src  = "stockfish.js";
        script_tag.type = "module";
        script_tag.onload = init;
        document.getElementsByTagName("head")[0].appendChild(script_tag);
        wait_for_script = true;
      }
    }());
    
    function init()
    {
      var pieceTheme = `<?php echo $front_full_path;?>/img/chesspieces/wikipedia/{piece}.png`;
      var game = engineGame(null, pieceTheme);

      newGame = function newGame() {
          var baseTime = parseFloat($('#timeBase').val()) * 60;
          var inc = parseFloat($('#timeInc').val());
          var skill = parseInt($('#skillLevel').val());
          game.reset();
          game.setTime(baseTime, inc);
          game.setSkillLevel(skill);
          game.setPlayerColor($('#color-white').hasClass('active') ? 'white' : 'black');
          game.setDisplayScore($('#showScore').is(':checked'));
          game.start();
      }
      
      game.setSkillLevel
      
      document.getElementById("skillLevel").addEventListener("change", function ()
      {
          game.setSkillLevel(parseInt(this.value, 10));
      });

      newGame();
    }
    
    /// If we load Stockfish.js via a <script> tag, we need to wait until it loads.
    if (!wait_for_script) {
      document.addEventListener("DOMContentLoaded", init);
    }
  </script>
</div>