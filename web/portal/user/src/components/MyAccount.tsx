import { useEffect, useState } from 'react';
import { Box, Container, Grid, Typography } from '@mui/material';
import { Edit } from '@irontec/ivoz-ui';
import { useStoreState } from 'store';
import TwoFactorSettings from './TwoFactorSettings';
import axios from 'axios';
import config from '../config';

export default function MyAccount(): JSX.Element {
  const [userId, setUserId] = useState<number | null>(null);
  const [twoFactorEnabled, setTwoFactorEnabled] = useState(false);
  const [loading, setLoading] = useState(true);
  
  // Load user profile data
  useEffect(() => {
    const fetchUserProfile = async () => {
      try {
        const response = await axios.get(`${config.API_URL}/my/profile`);
        if (response.data && response.data.id) {
          setUserId(response.data.id);
          setTwoFactorEnabled(!!response.data.twoFactorEnabled);
        }
      } catch (error) {
        console.error('Failed to load user profile', error);
      } finally {
        setLoading(false);
      }
    };
    
    fetchUserProfile();
  }, []);
  
  // Handle 2FA settings update
  const handleTwoFactorUpdate = async () => {
    try {
      const response = await axios.get(`${config.API_URL}/my/profile`);
      if (response.data && response.data.id) {
        setTwoFactorEnabled(!!response.data.twoFactorEnabled);
      }
    } catch (error) {
      console.error('Failed to refresh user profile', error);
    }
  };
  
  return (
    <Container maxWidth="lg" sx={{ mt: 4, mb: 4 }}>
      <Grid container spacing={3}>
        {/* Account Edit Form */}
        <Grid item xs={12}>
          <Edit entityName="my/account" />
        </Grid>
        
        {/* Two-Factor Authentication Settings */}
        <Grid item xs={12} sx={{ mt: 4 }}>
          {loading ? (
            <Typography>Loading...</Typography>
          ) : userId ? (
            <TwoFactorSettings
              userId={userId}
              twoFactorEnabled={twoFactorEnabled}
              onUpdate={handleTwoFactorUpdate}
            />
          ) : (
            <Typography color="error">Failed to load user profile</Typography>
          )}
        </Grid>
      </Grid>
    </Container>
  );
}