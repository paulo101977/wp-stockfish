<?php
  $board_id = md5(uniqid(rand(), true));   
?>
<div class="board-container">
  <div class="board-row">
    <div class="board-col">
      <span class="h3" id="time1">0:05:00</span>
      <div 
        id="board-<?php echo $board_id; ?>" 
        class="chess-board">
      </div>
      <span id="time2">0:05:00</span>
      <hr>
      <div id="engineStatus">...</div>
    </div>
    <div class="info-col">
      <p class="board-moves">Moves:</p>
      <div id="pgn"></div>
      <hr>
      <!-- form -->
      <?php include("form.php"); ?>

      <h5>Evaluation</h5>
      <pre id=evaluation></pre>
  </div>


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
      var j$ =  jQuery.noConflict(); 
      var pieceTheme = `<?php echo plugins_url('', dirname(__FILE__)) . '/front/img/chesspieces/wikipedia/{piece}.png'; ?>`;

      var game = engineGame(null, pieceTheme, '<?php echo $board_id; ?>');

      newGame = function newGame() {
          var baseTime = parseFloat(j$('#timeBase').val()) * 60;
          var inc = parseFloat(j$('#timeInc').val());
          var skill = parseInt(j$('#skillLevel').val());
          game.reset();
          game.setTime(baseTime, inc);
          game.setSkillLevel(skill);
          game.setPlayerColor(j$('#color-white').hasClass('active') ? 'white' : 'black');
          game.setDisplayScore(j$('#showScore').is(':checked'));
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