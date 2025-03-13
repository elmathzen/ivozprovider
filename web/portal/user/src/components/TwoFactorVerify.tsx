import { Button, TextField, Typography, Box, Paper } from '@mui/material';
import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useStoreActions } from 'store';
import axios from 'axios';
import config from '../config';

interface TwoFactorVerifyProps {
  tempToken: string;
  onCancel: () => void;
}

export default function TwoFactorVerify(props: TwoFactorVerifyProps): JSX.Element {
  const { tempToken, onCancel } = props;
  const [code, setCode] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();
  const setToken = useStoreActions((actions) => actions.auth.setToken);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!code) {
      setError('Please enter your verification code');
      return;
    }

    setIsLoading(true);
    setError(null);

    try {
      const response = await axios.post(
        `${config.API_URL}/two-factor/verify`,
        {
          code,
          token: tempToken,
        }
      );

      if (response.data && response.data.token) {
        // Set the token in the store
        setToken(response.data.token);
        
        // Navigate to the dashboard
        navigate('/');
      } else {
        setError('Invalid response from server');
      }
    } catch (err: any) {
      setError(err.response?.data?.error || 'Failed to verify code');
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <Paper elevation={3} sx={{ p: 4, maxWidth: 400, mx: 'auto', mt: 8 }}>
      <Typography variant="h5" component="h1" gutterBottom>
        Two-Factor Authentication
      </Typography>
      <Typography variant="body1" sx={{ mb: 3 }}>
        Please enter the verification code from your authenticator app.
      </Typography>

      <form onSubmit={handleSubmit}>
        <TextField
          label="Verification Code"
          variant="outlined"
          fullWidth
          value={code}
          onChange={(e) => setCode(e.target.value)}
          error={!!error}
          helperText={error}
          sx={{ mb: 3 }}
          inputProps={{ inputMode: 'numeric', pattern: '[0-9]*' }}
          autoFocus
        />

        <Box sx={{ display: 'flex', justifyContent: 'space-between' }}>
          <Button
            variant="outlined"
            onClick={onCancel}
            disabled={isLoading}
          >
            Cancel
          </Button>
          <Button
            type="submit"
            variant="contained"
            color="primary"
            disabled={isLoading}
          >
            {isLoading ? 'Verifying...' : 'Verify'}
          </Button>
        </Box>
      </form>
    </Paper>
  );
}