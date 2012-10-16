<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category    Gc
 * @package     Library
 * @subpackage  Property
 * @author      Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license     GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link        http://www.got-cms.com
 */

namespace Gc\Property;

use Gc\Db\AbstractTable,
    Zend\Db\TableGateway\TableGateway;
/**
 * Property Model
 */
class Model extends AbstractTable
{
    /**
     * Accessor for \Gc\Property\Value\Model
     * @var \Gc\Property\Value\Model
     */
    protected         $_value;

    /**
     * Table name
     * @var string
     */
    protected         $_name = 'property';

    /**
     * Get if property is required or not
     * @param Boolean $value to set value
     * @return mixte
     */
    public function isRequired($value = NULL)
    {
        if($value === NULL)
        {
            return $this->getData('required');
        }

        if($value === TRUE)
        {
            $this->setData('required', TRUE);
        }
        else
        {
            $this->setData('required', FALSE);
        }

        return $this;
    }

    /**
     * Set property value
     * @param mixte $value
     * @return \Gc\Property\Model
     */
    public function setValue($value)
    {
        $this->_value->setValue($value);

        return $this;
    }

    /**
     * Load property value
     * @return void
     */
    public function loadValue()
    {
        $property_value = new Value\Model();
        $property_value->load(NULL, $this->getDocumentId(), $this->getId());

        $this->_value = $property_value;
    }

    /**
     * Return property value
     * @return mixte
     */
    public function getValue()
    {
        if(empty($this->_value))
        {
            $this->loadValue();
        }

        return $this->_value->getValue();
    }

    /**
     * Return property value model
     * @return mixte
     */
    public function getValueModel()
    {
        if(empty($this->_value))
        {
            $this->loadValue();
        }

        return $this->_value;
    }

    /**
     * Save property value
     * @return boolean
     */
    public function saveValue()
    {
        $value = $this->getValue();
        $this->_value->save();
        if($value === '' and $this->isRequired())
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Save property
     * @return integer
     */
    public function save()
    {
        $this->events()->trigger(__CLASS__, 'beforeSave', NULL, array('object' => $this));
        $array_save = array(
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'identifier' => $this->getIdentifier(),
            'required' => $this->isRequired() == TRUE ? 'TRUE' : 'FALSE',
            'sort_order' => $this->getOrder(),
            'tab_id' => $this->getTabId(),
            'datatype_id' => $this->getDatatypeId(),
        );

        try
        {
            $id = $this->getId();
            if(empty($id))
            {
                $this->insert($array_save);
                $this->setId($this->getLastInsertId());
            }
            else
            {
                $this->update($array_save, sprintf('id =  %s', (int)$this->getId()));
            }

            $this->events()->trigger(__CLASS__, 'afterSave', NULL, array('object' => $this));

            return $this->getId();
        }
        catch (Exception $e)
        {
            /**
            * TODO(Make \Gc\Error)
            */
            \Gc\Error::set(get_class($this),$e);
        }

        $this->events()->trigger(__CLASS__, 'afterSaveFailed', NULL, array('object' => $this));

        return FALSE;
    }

    /**
     * Delete property
     * @return boolean
     */
    public function delete()
    {
        $id = $this->getId();
        if(!empty($id))
        {
            try
            {
                parent::delete(sprintf('id = %s', (int)$id));
                $table = new TableGateway('property_value', $this->getAdapter());
                $result = $table->delete(array('property_id' => (int)$id));
            }
            catch(Exception $e)
            {
                throw new \Gc\Exception($e->getMessage());

            }
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Initiliaze model from array
     * @param array $array
     * @return \Gc\Property\Model
     */
    static function fromArray(array $array)
    {
        $property = new Model();
        $property->setData($array);

        return $property;
    }

    /**
     * Initiliaze model from id
     * @param integer $id
     * @return \Gc\Property\Model
     */
    static function fromId($id)
    {
        $property_table = new Model();
        $row = $property_table->select(array('id' => $id));
        $current = $row->current();
        if(!empty($current))
        {
            return $property_table->setData((array)$current);
        }
        else
        {
            return FALSE;
        }
    }
}
