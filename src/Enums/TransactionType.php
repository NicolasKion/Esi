<?php

namespace NicolasKion\Esi\Enums;

enum TransactionType: string
{

    case AccelerationGateFee = 'acceleration_gate_fee';
    case AdvertisementListingFee = 'advertisement_listing_fee';
    case AgentDonation = 'agent_donation';
    case AgentLocationServices = 'agent_location_services';
    case AgentMiscellaneous = 'agent_miscellaneous';
    case AgentMissionCollateralPaid = 'agent_mission_collateral_paid';
    case AgentMissionCollateralRefunded = 'agent_mission_collateral_refunded';
    case AgentMissionReward = 'agent_mission_reward';
    case AgentMissionRewardCorporationTax = 'agent_mission_reward_corporation_tax';
    case AgentMissionTimeBonusReward = 'agent_mission_time_bonus_reward';
    case AgentMissionTimeBonusRewardCorporationTax = 'agent_mission_time_bonus_reward_corporation_tax';
    case AgentSecurityServices = 'agent_security_services';
    case AgentServicesRendered = 'agent_services_rendered';
    case AgentsPreward = 'agents_preward';
    case AllianceMaintenanceFee = 'alliance_maintainance_fee';
    case AllianceRegistrationFee = 'alliance_registration_fee';
    case AssetSafetyRecoveryTax = 'asset_safety_recovery_tax';
    case Bounty = 'bounty';
    case BountyPrize = 'bounty_prize';
    case BountyPrizeCorporationTax = 'bounty_prize_corporation_tax';
    case BountyPrizes = 'bounty_prizes';
    case BountyReimbursement = 'bounty_reimbursement';
    case BountySurcharge = 'bounty_surcharge';
    case BrokersFee = 'brokers_fee';
    case CloneActivation = 'clone_activation';
    case CloneTransfer = 'clone_transfer';
    case ContrabandFine = 'contraband_fine';
    case ContractAuctionBid = 'contract_auction_bid';
    case ContractAuctionBidCorp = 'contract_auction_bid_corp';
    case ContractAuctionBidRefund = 'contract_auction_bid_refund';
    case ContractAuctionSold = 'contract_auction_sold';
    case ContractBrokersFee = 'contract_brokers_fee';
    case ContractBrokersFeeCorp = 'contract_brokers_fee_corp';
    case ContractCollateral = 'contract_collateral';
    case ContractCollateralDepositedCorp = 'contract_collateral_deposited_corp';
    case ContractCollateralPayout = 'contract_collateral_payout';
    case ContractCollateralRefund = 'contract_collateral_refund';
    case ContractDeposit = 'contract_deposit';
    case ContractDepositCorp = 'contract_deposit_corp';
    case ContractDepositRefund = 'contract_deposit_refund';
    case ContractDepositSalesTax = 'contract_deposit_sales_tax';
    case ContractPrice = 'contract_price';
    case ContractPricePaymentCorp = 'contract_price_payment_corp';
    case ContractReversal = 'contract_reversal';
    case ContractReward = 'contract_reward';
    case ContractRewardDeposited = 'contract_reward_deposited';
    case ContractRewardDepositedCorp = 'contract_reward_deposited_corp';
    case ContractRewardRefund = 'contract_reward_refund';
    case ContractSalesTax = 'contract_sales_tax';
    case Copying = 'copying';
    case CorporateRewardPayout = 'corporate_reward_payout';
    case CorporateRewardTax = 'corporate_reward_tax';
    case CorporationAccountWithdrawal = 'corporation_account_withdrawal';
    case CorporationBulkPayment = 'corporation_bulk_payment';
    case CorporationDividendPayment = 'corporation_dividend_payment';
    case CorporationLiquidation = 'corporation_liquidation';
    case CorporationLogoChangeCost = 'corporation_logo_change_cost';
    case CorporationPayment = 'corporation_payment';
    case CorporationRegistrationFee = 'corporation_registration_fee';
    case CourierMissionEscrow = 'courier_mission_escrow';
    case Cspa = 'cspa';
    case CspaOfflineRefund = 'cspaofflinerefund';
    case DailyChallengeReward = 'daily_challenge_reward';
    case DatacoreFee = 'datacore_fee';
    case DnaModificationFee = 'dna_modification_fee';
    case DockingFee = 'docking_fee';
    case DuelWagerEscrow = 'duel_wager_escrow';
    case DuelWagerPayment = 'duel_wager_payment';
    case DuelWagerRefund = 'duel_wager_refund';
    case EssEscrowTransfer = 'ess_escrow_transfer';
    case ExternalTradeDelivery = 'external_trade_delivery';
    case ExternalTradeFreeze = 'external_trade_freeze';
    case ExternalTradeThaw = 'external_trade_thaw';
    case FactorySlotRentalFee = 'factory_slot_rental_fee';
    case FluxPayout = 'flux_payout';
    case FluxTax = 'flux_tax';
    case FluxTicketRepayment = 'flux_ticket_repayment';
    case FluxTicketSale = 'flux_ticket_sale';
    case GmCashTransfer = 'gm_cash_transfer';
    case IndustryJobTax = 'industry_job_tax';
    case InfrastructureHubMaintenance = 'infrastructure_hub_maintenance';
    case Inheritance = 'inheritance';
    case Insurance = 'insurance';
    case ItemTraderPayment = 'item_trader_payment';
    case JumpCloneActivationFee = 'jump_clone_activation_fee';
    case JumpCloneInstallationFee = 'jump_clone_installation_fee';
    case KillRightFee = 'kill_right_fee';
    case LpStore = 'lp_store';
    case Manufacturing = 'manufacturing';
    case MarketEscrow = 'market_escrow';
    case MarketFinePaid = 'market_fine_paid';
    case MarketProviderTax = 'market_provider_tax';
    case MarketTransaction = 'market_transaction';
    case MedalCreation = 'medal_creation';
    case MedalIssued = 'medal_issued';
    case MilegrayRewardPayment = 'milegray_reward_payment';
    case MissionCompletion = 'mission_completion';
    case MissionCost = 'mission_cost';
    case MissionExpiration = 'mission_expiration';
    case MissionReward = 'mission_reward';
    case OfficeRentalFee = 'office_rental_fee';
    case OperationBonus = 'operation_bonus';
    case OpportunityReward = 'opportunity_reward';
    case PlanetaryConstruction = 'planetary_construction';
    case PlanetaryExportTax = 'planetary_export_tax';
    case PlanetaryImportTax = 'planetary_import_tax';
    case PlayerDonation = 'player_donation';
    case PlayerTrading = 'player_trading';
    case ProjectDiscoveryReward = 'project_discovery_reward';
    case ProjectDiscoveryTax = 'project_discovery_tax';
    case Reaction = 'reaction';
    case RedeemedIskToken = 'redeemed_isk_token';
    case ReleaseOfImpoundedProperty = 'release_of_impounded_property';
    case RepairBill = 'repair_bill';
    case ReprocessingTax = 'reprocessing_tax';
    case ResearchingMaterialProductivity = 'researching_material_productivity';
    case ResearchingTechnology = 'researching_technology';
    case ResearchingTimeProductivity = 'researching_time_productivity';
    case ResourceWarsReward = 'resource_wars_reward';
    case ReverseEngineering = 'reverse_engineering';
    case SeasonChallengeReward = 'season_challenge_reward';
    case SecurityProcessingFee = 'security_processing_fee';
    case Shares = 'shares';
    case SkillPurchase = 'skill_purchase';
    case SovereignityBill = 'sovereignity_bill';
    case StorePurchase = 'store_purchase';
    case StorePurchaseRefund = 'store_purchase_refund';
    case StructureGateJump = 'structure_gate_jump';
    case TransactionTax = 'transaction_tax';
    case UpkeepAdjustmentFee = 'upkeep_adjustment_fee';
    case WarAllyContract = 'war_ally_contract';
    case WarFee = 'war_fee';
    case WarFeeSurrender = 'war_fee_surrender';
}