import Vue from 'vue';
import { byteToSize } from '../utils/byte-to-size';

Vue.filter('formatSize', (bytes) => {
    return byteToSize(bytes);
});

Vue.filter('formatFieldName', (name) => {
    if (!name) {
        return name;
    }

    return name
        .split('_')
        .map((i) => i.charAt(0).toUpperCase() + i.slice(1))
        .join(' ');
});
