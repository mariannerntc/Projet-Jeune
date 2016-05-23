<div class="ui container">
  <div class="ui stackable two column divided grid"> 
    <div class="column">
      <div class="ui pink segment">
        <p>
        Confirmez cette expérience que vous avez pu constater au contact de ce jeune.
        </p>
      </div>
    </div>

    <div class="column">
      <div class="ui green segment">
        <form class="ui form">
          <h4 class="ui dividing header">Savoir-être</h4>
      		<div class="field">
            <select multiple="" class="ui dropdown" name="savoirEtre">
              <option value="">Selectionner ses savoir être</option>
              <option value="CO">Confiance</option>
              <option value="BI">Bienveillance</option> 
              <option value="RE">Respect</option> 
              <option value="HO">Honnêteté</option> 
              <option value="TO">Tolérance</option> 
              <option value="JU">Juste</option> 
              <option value="IM">Impartial</option> 
              <option value="TR">Travail</option> 
            </select>
          </div>

          <h4 class="ui dividing header">Identité</h4>
          <div class=" field">
              <label>Nom et Prénom</label>
                <div class="two fields">
                  <div class="field">
                    <input type="text" name="shipping[last-name]" placeholder="Nom">
                  </div>
                  <div class="field">
                    <input type="text" name="shipping[first-name]" placeholder="Prénom">
                  </div>
                </div>
          </div>
          <div class="field">
            <label>Date de naissance</label>
            <div class="inline fields">
              <div class="three wide field">
                <input type="text" name="jourNaissance" placeholder="17">
              </div>
              <div class="eight wide field">
                <input type="text" name="moisNaissance" placeholder="Janvier">
              </div>
              <div class="five wide field">
                <input type="text" name="anneeNaissance" placeholder="1977">
              </div>
            </div>
          </div>
          <div class="field">
            <label>E-mail</label>
            <input placeholder="abc@domaine.com" type="email">
          </div>

          <h4 class="ui dividing header">Ajouter un commentaire</h4>
          <div class="field" name="commentary">
            <textarea></textarea>
          </div>

          <div class="ui error message"></div>

          <input class="ui submit green button" type="submit" value="Confirmer l'expérience" name="valider">
        </form>
      </div>
    </div>
  </div>
</div>

<script> // Active checkbox
$('select.dropdown')
  .dropdown()
;
$('.ui.form')
  .form({
    fields: {
      savoiretre :{
        identifier :'savoirEtre',
        rules: [
          {
            type   : 'maxCount[4]',
            prompt : 'Veuillez selectionner au maximum 4 savoir-être'
          },
          {
            type   : 'minCount[1]',
            prompt : 'Veuillez selectionner au minimum 1 savoir-être'
          }
        ]
      }
    }
  })
</script>