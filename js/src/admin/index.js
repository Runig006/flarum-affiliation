import app from 'flarum/admin/app';

app.initializers.add('runig006-affiliation', () => {
  // Register extension settings page
  app.extensionData
    .for('runig006-affiliation')
    .registerSetting({
      type: 'textarea',
      setting: 'runig006-flarum-affilation.json',
      label: app.translator.trans('runig006-flarum-affilation.admin.settings.label'),
      help: app.translator.trans('runig006-flarum-affilation.admin.settings.help'),
    })
});
