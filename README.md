YiiValidateRelation
===================

CFormModel validasi relasi
digunakan untuk memvalidasi value relasi , misal ada yang iseng inspect element seperti saya :D

Lokasi : protected/component/YiiFormModel.php.php

contoh penggunaan :

extends ke YiiFormModel

array('unit_type_id','validateRelation','relationField'=>'id','model'=>'CasGeneralLookups','where_parent_id'=>CasGeneralLookups::UNIT_TYPE_ID,'required'=>'no'),
array('product_id','validateRelation','relationField'=>'id','model'=>'CasSaProductDefinitions'),

Kabar Gembira , untuk pengecekan 2 parameter atau lebih , gunakan prefix where_fieldName
