let $regione = $( '#regione' ),
$provincia = $( '#provincia' ),
$options = $provincia.find( 'option' );

$regione.on( 'change', function() {
$provincia.html( $options.filter( '[value="' + this.value + '"]' ) );
} ).trigger( 'change' );


let $regione1 = $( '#regione1' ),
$provincia1 = $( '#provincia1' ),
$options1 = $provincia1.find( 'option' );

$regione1.on( 'change', function() {
$provincia1.html( $options1.filter( '[value="' + this.value + '"]' ) );
} ).trigger( 'change' );


let $regione2 = $( '#regione2' ),
$provincia2 = $( '#provincia2' ),
$options2 = $provincia2.find( 'option' );

$regione2.on( 'change', function() {
$provincia2.html( $options2.filter( '[value="' + this.value + '"]' ) );
} ).trigger( 'change' );


let $regione3 = $( '#regione3' ),
$provincia3 = $( '#provincia3' ),
$options3 = $provincia3.find( 'option' );

$regione3.on( 'change', function() {
$provincia3.html( $options3.filter( '[value="' + this.value + '"]' ) );
} ).trigger( 'change' );


let $regione4 = $( '#regione4' ),
$provincia4 = $( '#provincia4' ),
$options4 = $provincia4.find( 'option' );

$regione4.on( 'change', function() {
$provincia4.html( $options4.filter( '[value="' + this.value + '"]' ) );
} ).trigger( 'change' );

function accediRegistrati(id){
    $("#modalLoginRegister").modal("show");
    $("#" + id).click();
}









