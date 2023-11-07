import app from 'flarum/admin/app';
import SettingsPage from './SettingsPage';

app.initializers.add('runig006-affiliation', () => {
  // Register extension settings page
  app.extensionData.for('runig006-affiliation').registerPage(SettingsPage);
});
