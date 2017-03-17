<?php

class IiifItems_Integration_SimplePages extends IiifItems_BaseIntegration {
    public function initialize() {
        add_shortcode('mirador_file', array($this, 'shortcodeMiradorFile'));
        add_shortcode('mirador_items', array($this, 'shortcodeMiradorItems'));
        add_shortcode('mirador_collections', array($this, 'shortcodeMiradorCollections'));
        add_shortcode('mirador', array($this, 'shortcodeMirador'));
    }
    
    public function shortcodeMiradorFile($args, $view) {
        // Styles
        $styles = isset($args['style']) ? $args['style'] : '';
        // Single: View the file as-is
        if (isset($args['id'])) {
            $id = $args['id'];
            $file = get_record_by_id('File', $id);
            if ($file) {
                return '<iframe src="' . public_full_url(array('things' => 'files', 'id' => $id), 'iiifitems_mirador') . '" style="width:100%;height:400px;' . $styles . '"></iframe>';
            }
        }
        // Fail
        return '';
    }

    public function shortcodeMiradorItems($args, $view) {
        // Styles
        $styles = isset($args['style']) ? $args['style'] : '';
        // Multiple: Rip arguments from existing [items] shortcode, for finding items
        if (isset($args['ids'])) {
            $params = array();
            if (isset($args['is_featured'])) {
                $params['featured'] = $args['is_featured'];
            }
            if (isset($args['has_image'])) {
                $params['hasImage'] = $args['has_image'];
            }
            if (isset($args['collection'])) {
                $params['collection'] = $args['collection'];
            }
            if (isset($args['item_type'])) {
                $params['item_type'] = $args['item_type'];
            }
            if (isset($args['tags'])) {
                $params['tags'] = $args['tags'];
            }
            if (isset($args['user'])) {
                $params['user'] = $args['user'];
            }
            if (isset($args['ids'])) {
                $params['range'] = $args['ids'];
            }
            if (isset($args['sort'])) {
                $params['sort_field'] = $args['sort'];
            }
            if (isset($args['order'])) {
                $params['sort_dir'] = $args['order'];
            }
            if (isset($args['num'])) {
                $limit = $args['num'];
            } else {
                $limit = 10; 
            }
            $items = get_records('Item', $params, $limit);
            $item_ids = array();
            foreach ($items as $item) {
                $item_ids[] = $item->id;
            }
            // Add iframe
            return '<iframe src="' . public_full_url(array(), 'iiifitems_exhibit_mirador', array('items' => join(',', $item_ids))) . '" style="width:100%;height:400px;' . $styles . '" allowfullscreen="true"></iframe>';
        }
        // Single: View quick-view manifest of the item
        if (isset($args['id'])) {
            $id = $args['id'];
            $item = get_record_by_id('Item', $id);
            if ($item) {
                return '<iframe src="' . public_full_url(array('things' => 'items', 'id' => $id), 'iiifitems_mirador') . '" style="width:100%;height:400px;' . $styles . '" allowfullscreen="true"></iframe>';
            }
        }
        // Fail
        return '';
    }

    public function shortcodeMiradorCollections($args, $view) {
        // Styles
        $styles = isset($args['style']) ? $args['style'] : '';
        // Multiple: Rip arguments from existing [collections] shortcode, for finding collections
        if (isset($args['ids'])) {
            $params = array();
            if (isset($args['ids'])) {
                $params['range'] = $args['ids'];
            }
            if (isset($args['sort'])) {
                $params['sort_field'] = $args['sort'];
            }
            if (isset($args['order'])) {
                $params['sort_dir'] = $args['order'];
            }
            if (isset($args['is_featured'])) {
                $params['featured'] = $args['is_featured'];
            }
            if (isset($args['num'])) {
                $limit = $args['num'];
            } else {
                $limit = 10; 
            }
            $collections = get_records('Collection', $params, $limit);
            $collection_urls = array();
            foreach ($collections as $collection) {
                $collection_urls[] = public_full_url(array('things' => 'collections', 'id' => $collection->id), 'iiifitems_manifest');
            }
            // Add iframe
            return '<iframe src="' . public_full_url(array(), 'iiifitems_exhibit_mirador', array('u' => $collection_urls)) . '" style="width:100%;height:400px;' . $styles . '" allowfullscreen="true"></iframe>';
        }
        // Single: View quick-view manifest of the collection
        if (isset($args['id'])) {
            $id = $args['id'];
            $collection = get_record_by_id('Collection', $id);
            if ($collection) {
                return '<iframe src="' . public_full_url(array('things' => 'collections', 'id' => $id), 'iiifitems_mirador') . '" style="width:100%;height:400px;' . $styles . '" allowfullscreen="true"></iframe>';
            }
        }
        // Fail
        return '';
    }

    public function shortcodeMirador($args, $view) {
        // Styles
        $styles = isset($args['style']) ? $args['style'] : '';
        // Grab URL arguments
        $urls = isset($args['urls']) ? explode(';', $args['urls']) : array();
        // Add iframe
        return '<iframe src="' . public_full_url(array(), 'iiifitems_exhibit_mirador', array('u' => $urls)) . '" style="width:100%;height:400px;' . $styles . '" allowfullscreen="true"></iframe>';
    }
}
