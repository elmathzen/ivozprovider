import {
  Box,
  Button,
  Card,
  CardContent,
  CardHeader,
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Divider,
  Grid,
  List,
  ListItem,
  ListItemText,
  TextField,
  Typography,
} from '@mui/material';
import { useState } from 'react';
import axios from 'axios';
import config from '../config';
import QRCode from 'qrcode.react';

interface TwoFactorSettingsProps {
  userId: number;
  twoFactorEnabled: boolean;
  onUpdate: () => void;
}

export default function TwoFactorSettings(props: TwoFactorSettingsProps): JSX.Element {
  const { userId, twoFactorEnabled, onUpdate } = props;
  const [isEnabling, setIsEnabling] = useState(false);
  const [isDisabling, setIsDisabling] = useState(false);
  const [isRegeneratingCodes, setIsRegeneratingCodes] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState<string | null>(null);
  
  // Setup state
  const [setupData, setSetupData] = useState<{
    secret: string;
    qrCodeUrl: string;
    backupCodes: string[];
  } | null>(null);
  
  // Verification state
  const [verificationCode, setVerificationCode] = useState('');
  const [showVerificationDialog, setShowVerificationDialog] = useState(false);
  
  // Backup codes state
  const [backupCodes, setBackupCodes] = useState<string[]>([]);
  const [showBackupCodes, setShowBackupCodes] = useState(false);

  // Enable 2FA
  const handleEnable = async () => {
    setIsEnabling(true);
    setError(null);
    setSuccess(null);
    
    try {
      const response = await axios.post(
        `${config.API_URL}/my/two-factor/enable`,
        {},
        { withCredentials: true }
      );
      
      if (response.data && response.data.secret && response.data.qrCodeUrl) {
        setSetupData({
          secret: response.data.secret,
          qrCodeUrl: response.data.qrCodeUrl,
          backupCodes: response.data.backupCodes || [],
        });
        setShowVerificationDialog(true);
      } else {
        setError('Invalid response from server');
      }
    } catch (err: any) {
      setError(err.response?.data?.error || 'Failed to enable 2FA');
    } finally {
      setIsEnabling(false);
    }
  };

  // Verify code during setup
  const handleVerifySetup = async () => {
    if (!verificationCode) {
      setError('Please enter your verification code');
      return;
    }
    
    setIsEnabling(true);
    setError(null);
    
    try {
      // Send the verification code to the server
      const response = await axios.post(
        `${config.API_URL}/my/two-factor/verify-setup`,
        {
          code: verificationCode,
          secret: setupData?.secret
        },
        { withCredentials: true }
      );
      
      if (response.data && response.data.success) {
        setBackupCodes(setupData?.backupCodes || []);
        setShowVerificationDialog(false);
        setShowBackupCodes(true);
        setSuccess('Two-factor authentication has been enabled');
        onUpdate();
      } else {
        setError('Invalid verification code');
      }
    } catch (err: any) {
      setError(err.response?.data?.error || 'Failed to verify code');
    } finally {
      setIsEnabling(false);
    }
  };

  // Disable 2FA
  const handleDisable = async () => {
    setIsDisabling(true);
    setError(null);
    setSuccess(null);
    
    try {
      await axios.post(
        `${config.API_URL}/my/two-factor/disable`,
        {},
        { withCredentials: true }
      );
      
      setSuccess('Two-factor authentication has been disabled');
      onUpdate();
    } catch (err: any) {
      setError(err.response?.data?.error || 'Failed to disable 2FA');
    } finally {
      setIsDisabling(false);
    }
  };

  // Regenerate backup codes
  const handleRegenerateCodes = async () => {
    setIsRegeneratingCodes(true);
    setError(null);
    setSuccess(null);
    
    try {
      const response = await axios.post(
        `${config.API_URL}/my/two-factor/backup-codes`,
        {},
        { withCredentials: true }
      );
      
      if (response.data && response.data.backupCodes) {
        setBackupCodes(response.data.backupCodes);
        setShowBackupCodes(true);
        setSuccess('New backup codes have been generated');
      } else {
        setError('Invalid response from server');
      }
    } catch (err: any) {
      setError(err.response?.data?.error || 'Failed to regenerate backup codes');
    } finally {
      setIsRegeneratingCodes(false);
    }
  };

  return (
    <Card>
      <CardHeader title="Two-Factor Authentication" />
      <Divider />
      <CardContent>
        {error && (
          <Typography color="error" sx={{ mb: 2 }}>
            {error}
          </Typography>
        )}
        {success && (
          <Typography color="success.main" sx={{ mb: 2 }}>
            {success}
          </Typography>
        )}

        <Typography variant="body1" paragraph>
          Two-factor authentication adds an extra layer of security to your account by requiring a verification code in addition to your password.
        </Typography>

        {twoFactorEnabled ? (
          <Box>
            <Typography variant="body1" paragraph>
              Two-factor authentication is currently <strong>enabled</strong> for your account.
            </Typography>
            
            <Grid container spacing={2}>
              <Grid item>
                <Button
                  variant="outlined"
                  color="primary"
                  onClick={handleRegenerateCodes}
                  disabled={isRegeneratingCodes}
                >
                  {isRegeneratingCodes ? 'Generating...' : 'Generate New Backup Codes'}
                </Button>
              </Grid>
              <Grid item>
                <Button
                  variant="outlined"
                  color="error"
                  onClick={handleDisable}
                  disabled={isDisabling}
                >
                  {isDisabling ? 'Disabling...' : 'Disable Two-Factor Authentication'}
                </Button>
              </Grid>
            </Grid>
          </Box>
        ) : (
          <Box>
            <Typography variant="body1" paragraph>
              Two-factor authentication is currently <strong>disabled</strong> for your account.
            </Typography>
            
            <Button
              variant="contained"
              color="primary"
              onClick={handleEnable}
              disabled={isEnabling}
            >
              {isEnabling ? 'Enabling...' : 'Enable Two-Factor Authentication'}
            </Button>
          </Box>
        )}
      </CardContent>

      {/* Setup Dialog */}
      <Dialog open={showVerificationDialog} maxWidth="sm" fullWidth>
        <DialogTitle>Set Up Two-Factor Authentication</DialogTitle>
        <DialogContent>
          <Box sx={{ mt: 2 }}>
            <Typography variant="body1" paragraph>
              1. Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.)
            </Typography>
            
            <Box sx={{ display: 'flex', justifyContent: 'center', my: 3 }}>
              {setupData?.qrCodeUrl && (
                <QRCode value={setupData.qrCodeUrl} size={200} />
              )}
            </Box>
            
            <Typography variant="body1" paragraph>
              2. If you can't scan the QR code, enter this code manually:
            </Typography>
            
            <Typography variant="body1" sx={{ fontFamily: 'monospace', fontWeight: 'bold', my: 2 }}>
              {setupData?.secret}
            </Typography>
            
            <Typography variant="body1" paragraph>
              3. Enter the verification code from your authenticator app:
            </Typography>
            
            <TextField
              label="Verification Code"
              variant="outlined"
              fullWidth
              value={verificationCode}
              onChange={(e) => setVerificationCode(e.target.value)}
              sx={{ mt: 1 }}
              inputProps={{ inputMode: 'numeric', pattern: '[0-9]*' }}
              autoFocus
            />
          </Box>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setShowVerificationDialog(false)}>Cancel</Button>
          <Button onClick={handleVerifySetup} variant="contained" color="primary">
            Verify
          </Button>
        </DialogActions>
      </Dialog>

      {/* Backup Codes Dialog */}
      <Dialog open={showBackupCodes} maxWidth="sm" fullWidth>
        <DialogTitle>Backup Codes</DialogTitle>
        <DialogContent>
          <Typography variant="body1" paragraph sx={{ mt: 2 }}>
            Save these backup codes in a secure place. You can use them to sign in if you lose access to your authenticator app.
          </Typography>
          
          <Typography variant="body2" color="error" paragraph>
            Each code can only be used once.
          </Typography>
          
          <List dense sx={{ bgcolor: 'background.paper', border: '1px solid #ddd', borderRadius: 1 }}>
            {backupCodes.map((code, index) => (
              <ListItem key={index} divider={index < backupCodes.length - 1}>
                <ListItemText primary={code} sx={{ fontFamily: 'monospace' }} />
              </ListItem>
            ))}
          </List>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => setShowBackupCodes(false)} variant="contained" color="primary">
            Done
          </Button>
        </DialogActions>
      </Dialog>
    </Card>
  );
}