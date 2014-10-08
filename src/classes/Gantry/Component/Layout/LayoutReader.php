<?php
namespace Gantry\Component\Layout;

use RocketTheme\Toolbox\File\YamlFile;

class LayoutReader
{
    protected static $scopes = [0 => 'grid', 1 => 'block'];

    public static function read($file) {
        $file = YamlFile::instance($file);
        $content = $file->content();

        $result = [];
        foreach ($content as $field => $params) {
            $child = self::parse($field, $params, 0);
            unset($child['size']);

            $result[] = $child;
        }

        return $result;
    }

    public static function parse($field, $content, $scope)
    {
        if (is_numeric($field))  {
            $result = ['type' => self::$scopes[$scope]];
            $scope = ($scope + 1) % 2;
        } else {
            $list = explode(' ', $field, 2);
            $field = array_shift($list);
            $size = array_shift($list);

            $result = [
                'type' => 'section',
                'size' => (int) $size,
                'attributes' => [
                    'name' => 'Section ' . ucfirst($field),
                    'key' => "section-{$field}",
                    'type' => $field,
                    'id' => $field
                ]
            ];
        }

        foreach ($content as $child => $params) {
            if (is_array($params)) {
                $child = self::parse($child, $params, $scope);
            } else {
                $child = self::resolve($params, $scope);
            }
            if (!empty($child['size'])) {
                $result['attributes']['size'] = $child['size'];
            }
            unset($child['size']);
            $result['children'][] = $child;
        }

        return $result;
    }

    public static function resolve($field, $scope)
    {
        $list = explode(' ', $field, 2);
        $list2 = explode('-', array_shift($list), 2);
        $size = array_shift($list);
        $type = array_shift($list2);
        $name = array_shift($list2);

        $attributes = [];
        if ($name) {
            $attributes['name'] = $name;
            $attributes['key'] = $name;
        }

        $result = ['type' => $type, 'attributes' => $attributes];

        if ($scope > 1) {
            return $result;
        }
        if ($scope <= 1) {
            $result = ['type' => 'block', 'children' => [$result]];
            if ($size) {
                $result['attributes']['size'] = (int) $size;
            }
        }
        if ($scope == 0) {
            $result = ['type' => 'grid', 'children' => [$result]];
        }

        return $result;
    }
}