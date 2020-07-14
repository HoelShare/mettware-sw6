import MettwarePlugin from './js/mettware-plugin.plugin';

// register them via the existing PluginManager
const PluginManager = window.PluginManager;
PluginManager.register('MettwarePlugin', MettwarePlugin, '[data-mettware-plugin]');
