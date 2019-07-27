<?php
  $front_full_path  = plugins_url() . '/wp-stockfish/src/front/';
?>

<!doctype html>
<html>
  <head>
    <link rel="stylesheet" href="<?php echo $front_full_path;?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $front_full_path;?>css/chessboard-0.3.0.min.css" />
    <script src="<?php echo $front_full_path;?>js/jquery-1.10.1.min.js"></script>
    <script src="<?php echo $front_full_path;?>js/bootstrap.min.js"></script>
    <script src="<?php echo $front_full_path;?>js/chess.min.js"></script>
    <script src="<?php echo $front_full_path;?>js/chessboard-0.3.0.min.js"></script>
    <title>Stockfish.js</title>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-7 col-md-6">
        <span class="h3" id="time1">0:05:00</span>
        <div id="board" style="width: 400px"></div>
        <span class="h3" id="time2">0:05:00</span>
        <hr>
        <div id="engineStatus">...</div>
      </div>
      <div class="col-sm-5 col-md-6">
        <h3>Moves:</h3>
        <div id="pgn"></div>
        <hr>
        <form class="form-horizontal">
          <div class="form-group">
            <label for="timeBase" class="control-label col-xs-4 col-sm-6 col-md-4">Base time (min)</label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <input type="number" class="form-control" id="timeBase" value="5">
            </div>
          </div>
          <div class="form-group">
            <label for="timeInc" class="control-label col-xs-4 col-sm-6 col-md-4">Increment (sec)</label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <input type="number" class="form-control" id="timeInc" value="2">
            </div>
          </div>
          <div class="form-group">
            <label for="skillLevel" class="control-label col-xs-4 col-sm-6 col-md-4">Skill Level (0-20)</label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <input type="number" class="form-control" id="skillLevel" value="0">
            </div>
          </div>
          <div class="form-group">
            <label for="color" class="control-label col-xs-4 col-sm-6 col-md-4">I play</label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary active" id="color-white"><input type="radio" name="color">White</label>
                <label class="btn btn-primary" id="color-black"><input type="radio" name="color">Black</label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="showScore" class="control-label col-xs-4 col-sm-6 col-md-4">Show score</label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <input type="checkbox" class="form-control" id="showScore" checked>
            </div>
          </div>
          <div class="form-group">
            <label for="color" class="control-label col-xs-4 col-sm-6 col-md-4"></label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <button type="button" class="btn btn-primary" onclick="newGame()">New Game</button>
            </div>
          </div>
          
          <div class="form-group">
            <label for="color" class="control-label col-xs-4 col-sm-6 col-md-4">Promote to</label>
            <div class="col-xs-4 col-sm-6 col-md-4">
              <select id=promote>
                <option value=q selected>Queen</option>
                <option value=r>Rook</option>
                <option value=b>Bishop</option>
                <option value=n>Knight</option>
              </select>
            </div>
          </div>
        </form>
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
  </body>
</html>
