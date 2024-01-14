<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 * @property AuthRule $ruleName
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery|AuthAssignmentQuery
     */
    // public function getAuthAssignments()
    // {
    //     return $this->hasMany(AuthAssignment::class, ['item_name' => 'name']);
    // }

    /**
     * Gets query for [[AuthItemChildren]].
     *
     * @return \yii\db\ActiveQuery|AuthItemChildQuery
     */
    // public function getAuthItemChildren()
    // {
    //     return $this->hasMany(AuthItemChild::class, ['parent' => 'name']);
    // }

    /**
     * Gets query for [[AuthItemChildren0]].
     *
     * @return \yii\db\ActiveQuery|AuthItemChildQuery
     */
    // public function getAuthItemChildren0()
    // {
    //     return $this->hasMany(AuthItemChild::class, ['child' => 'name']);
    // }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery|AuthItemQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery|AuthItemQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery|AuthRuleQuery
     */
    // public function getRuleName()
    // {
    //     return $this->hasOne(AuthRule::class, ['name' => 'rule_name']);
    // }

    /**
     * {@inheritdoc}
     * @return AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemQuery(get_called_class());
    }

    public function saveRol() 
{
    $auth = Yii::$app->authManager;

    // Verificar si la regla existe
    $rule = $auth->getRule($this->rule_name);
    if ($rule != null) {
        // Si no existe, crear la regla
        $newRule = $auth->createRule($this->rule_name);
        // Configurar las propiedades de la regla según tus necesidades
        $auth->add($newRule);
    }

    // Crear el rol
    $rol = $auth->createRole($this->name);
    $rol->description = $this->description;
    $rol->ruleName = $rule != null ? $rule->name : null;
    $rol->data = $this->data;
    $rol->createdAt = time();


    return $auth->add($rol);
}


    // metodo para modificar el rol
    public function updateRol($name) 
    {
        $auth = Yii::$app->authManager;

        // Verificar si la regla existe
        $rule = $auth->getRule($this->rule_name);
        if ($rule != null) {
            // Si no existe, crear la regla
            $newRule = $auth->createRule($this->rule_name);
            // Configurar las propiedades de la regla según tus necesidades
            $auth->add($newRule);
        }

        // Crear el rol
        $rol = $auth->createRole($name);
        $rol->description = $this->description;
        $rol->ruleName = $rule != null ? $rule->name : null;
        $rol->data = $this->data;
        $rol->createdAt = $this->created_at;
        $rol->updatedAt = time();

        return $auth->update($name, $rol);
    }
    
}
